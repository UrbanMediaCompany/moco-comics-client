const paypal = require('@paypal/checkout-server-sdk');
const asyncFetch = require('./async-fetch');

const Environment = new paypal.core.SandboxEnvironment(
  process.env.GATSBY_PAYPAL_CLIENT_ID,
  process.env.PAYPAL_CLIENT_SECRET,
);
const Client = new paypal.core.PayPalHttpClient(Environment);

exports.handler = async ({ body }) => {
  const { cart, isInternationalShipping } = JSON.parse(body);

  // 1. Authenticate service

  const [authError, { jwt }] = await asyncFetch(`${process.env.STRAPI_URL}/auth/local`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ identifier: process.env.STRAPI_IDENTIFIER, password: process.env.STRAPI_PASSWORD }),
  });

  if (authError || !jwt) {
    return {
      statusCode: 502,
      body: JSON.stringify({ error: 502, message: 'Unable to authenticate with products provider.' }),
    };
  }

  // 2. Populate cart items

  const productRequests = cart.map((item) =>
    asyncFetch(`${process.env.STRAPI_URL}/products/${item.id}`, { headers: { Authorization: `Bearer ${jwt}` } }),
  );
  const productResponses = await Promise.all(productRequests);
  const populatedProducts = productResponses.map(([error, product]) => (error ? null : product)).filter(Boolean);
  const normalizedProducts = populatedProducts.reduce((acc, product) => {
    acc[product.id] = product;
    return acc;
  }, {});

  // 3. Create PayPal Order

  let orderItemsTotalValue = 0;
  const orderItems = cart.map((item) => {
    const product = normalizedProducts[item.id];
    orderItemsTotalValue += item.quantity * product.price;

    return {
      name: product.name,
      quantity: item.quantity,
      category: product.files.length ? 'DIGITAL_GOODS' : 'PHYSICAL_GOODS',
      unit_amount: {
        currency_code: 'MXN',
        value: product.price,
      },
    };
  });

  const orderBody = {
    intent: 'CAPTURE',
    purchase_units: [
      {
        amount: {
          currency_code: 'MXN',
          value: isInternationalShipping
            ? orderItemsTotalValue + Number(process.env.SHIPPING_COST)
            : orderItemsTotalValue,
          breakdown: {
            item_total: {
              currency_code: 'MXN',
              value: orderItemsTotalValue,
            },
          },
        },
        items: orderItems,
      },
    ],
  };

  if (isInternationalShipping)
    orderBody.purchase_units[0].amount.breakdown.shipping = {
      currency_code: 'MXN',
      value: process.env.SHIPPING_COST,
    };

  const orderRequest = new paypal.orders.OrdersCreateRequest();
  orderRequest.prefer('return=representation');
  orderRequest.requestBody(orderBody);

  try {
    const order = await Client.execute(orderRequest);

    return {
      statusCode: 200,
      body: JSON.stringify({ order: order.result.id }),
    };
  } catch (e) {
    console.log(e);

    return {
      statusCode: 500,
      body: JSON.stringify({ error: 500, data: e }),
    };
  }
};
