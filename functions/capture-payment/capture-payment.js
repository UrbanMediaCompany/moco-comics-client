const paypal = require('@paypal/checkout-server-sdk');

const Environment = new paypal.core.LiveEnvironment(
  process.env.GATSBY_PAYPAL_CLIENT_ID,
  process.env.PAYPAL_CLIENT_SECRET,
);
const Client = new paypal.core.PayPalHttpClient(Environment);

exports.handler = async ({ body }) => {
  const { orderID } = JSON.parse(body);

  const request = new paypal.orders.OrdersCaptureRequest(orderID);
  request.requestBody({});

  try {
    const capture = await Client.execute(request);

    return {
      statusCode: 200,
      body: JSON.stringify({ capture }),
    };
  } catch (e) {
    console.log(e);

    return {
      statusCode: 500,
      body: JSON.stringify({ error: 500, data: e }),
    };
  }
};
