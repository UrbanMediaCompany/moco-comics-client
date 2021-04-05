import React, { useEffect, useRef, useState } from 'react';
import { StaticImage } from 'gatsby-plugin-image';
import PropTypes from 'prop-types';
import TrashIcon from '../assets/icons/trash.svg';
import CloseIcon from '../assets/icons/x.svg';
import useMatchMedia from '../hooks/useMatchMedia';
import formatMoney from '../utils/formatMonej';
import loadPayPalSDK from '../utils/loadPayPalSDK';
import * as styles from './ShoppingCart.module.css';

const ShoppingCart = ({ items, products, updateCartItem, removeFromCart, onPurchaseIntent }) => {
  const isMobileViewport = useMatchMedia('(max-width: 767px)');

  const [isCartOpen, setIsCartOpen] = useState(false);
  const [isInternationalShipping, setIsInternationalShipping] = useState(false);

  const [purchaseSuccess, setPurchaseSuccess] = useState(false);
  const [, setPurchaseError] = useState(false);

  const [, setPayer] = useState();

  const disablePaypalButtons = useRef(() => {});
  const enablePaypalButtons = useRef(() => {});

  const [total] = [items.reduce((acc, item) => acc + products[item.id].price * item.quantity, 0)].map(formatMoney);

  const isLayoutOpened = isMobileViewport && isCartOpen;

  const initPaypalButtons = (_, actions) => {
    // Disable buttons on load
    actions.disable();

    // We'll need these in the future so keep a reference
    disablePaypalButtons.current = actions.disable;
    enablePaypalButtons.current = actions.enable;
  };

  const onPaypalButtonClick = ({ fundingSource }) => {
    setPurchaseSuccess(false);
    setPurchaseError(false);
    onPurchaseIntent(fundingSource);
  };

  const createPaypalOrder = () => {
    return fetch('/.netlify/functions/checkout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ cart: items, isInternationalShipping: isInternationalShipping }),
    })
      .then((res) => res.json())
      .then(({ order }) => order)
      .catch((err) => [err]);
  };

  const onPaypalOrderApproved = (data, actions) => {
    setPurchaseSuccess(true);
    onPurchaseIntent(null);

    return actions.order.capture().then(({ payer: { name } }) => {
      setPayer(`${name.given_name} ${name.surname}`);
    });
  };

  const onPaypalOrderCancelled = () => {
    onPurchaseIntent(null);
  };

  const onPaypalOrderError = () => {
    setPurchaseError(true);
    onPurchaseIntent(null);
  };

  useEffect(() => {
    loadPayPalSDK().then(() => {
      window.paypal
        .Buttons({
          style: { label: 'pay' },
          onInit: initPaypalButtons,
          onClick: onPaypalButtonClick,
          createOrder: createPaypalOrder,
          onApprove: onPaypalOrderApproved,
          onCancel: onPaypalOrderCancelled,
          onError: onPaypalOrderError,
        })
        .render('#paypal-buttons');
    });
  }, []);

  useEffect(() => {
    if (items.length > 0) enablePaypalButtons.current();
    if (items.length === 0) disablePaypalButtons.current();
  }, [items]);

  return (
    <div
      className={`${
        styles.container
      } fixed left-0 right-0 flex flex-col items-stretch justify-end px-constrained z-20 transition-all duration-200 md:static md:px-0 md:mb-10 md:z-auto ${
        isLayoutOpened ? 'top-0 left-0 right-0 bottom-sa-3 h-screen pt-16 pb-sa-3 bg-black bg-opacity-50' : ''
      }`}
    >
      {/** Mobile over-tab-bar widget */}
      <div
        className={`flex flex-nowrap items-center md:hidden ${
          isLayoutOpened ? 'justify-between mb-8' : 'justify-center'
        }`}
      >
        <button
          type="button"
          onClick={() => setIsCartOpen(true)}
          className="block w-full max-w-md text-center font-cartoon text-white uppercase px-7 pt-6 pb-3 bg-mc-red rounded-full webkit-mask-image shadow-sm border-b-4 border-mc-red-500"
        >
          Total {total}
        </button>

        {!isLayoutOpened ? null : (
          <button
            onClick={() => setIsCartOpen(false)}
            type="button"
            className="bg-white rounded-full webkit-mask-image shadow-sm p-6 ml-4"
          >
            <CloseIcon className="text-mc-blue" />
          </button>
        )}
      </div>

      <div
        className={`flex flex-col items-center transition-all duration-200 h-0 overflow-hidden md:h-auto ${
          isLayoutOpened ? 'h-auto mb-10 md:mb-0' : ''
        }`}
      >
        <p className="hidden md:flex justify-center items-center w-60 h-60 rounded-full webkit-mask-image bg-mc-red text-white font-cartoon text-center border-b-10 border-mc-red-500 uppercase text-lg p-12 md:p-16">
          Total <br />
          {total}
        </p>

        {/** Checkout form */}
        <form className="w-full px-8 pt-6 bg-white rounded-xl md:-mt-12 shadow-sm overflow-y-auto">
          <legend className="w-full font-display mb-8 text-center">Artículos en tu carrito</legend>

          {items.length !== 0 ? null : <p className="text-sm text-center mb-8">No hay artículos en tu carrito...</p>}

          {items.map((item) => (
            <div className="grid grid-cols-cart-item gap-4 items-center py-3 border-b-2 border-dotted" key={item.id}>
              <p className="text-sm col-span-2">
                <span>{products[item.id].name}</span>
                <span> — {formatMoney(products[item.id].price)}</span>
              </p>

              <label className="relative font-display text-sm border-2 border-gray-200 rounded-lg hover:border-mc-yellow focus-within:border-mc-yellow transition-colors duration-200">
                <span className="absolute bottom-2 left-2 text-grey-400 mr-2">x</span>

                <input
                  type="number"
                  min="1"
                  max="10"
                  name="quantity"
                  onChange={({ target: { value } }) => updateCartItem({ id: item.id, quantity: Number(value) })}
                  value={item.quantity}
                  className="w-full h-full pl-8 p-2 appearance-none"
                />
              </label>

              <button
                onClick={() => removeFromCart(item.id)}
                type="button"
                className="justify-self-end hover:text-mc-red focus:text-mc-red transition-colors duration-200"
              >
                <TrashIcon className="w-8 h-8" />
              </button>
            </div>
          ))}

          <label className="flex flex-nowrap justify-center items-center cursor-pointer border-2 border-transparent px-3 py-4 mt-2 mb-4 rounded-lg focus-within:border-mc-blue focus-within:border-dashed transition-all duration-200">
            <input
              type="checkbox"
              name="international-shipping"
              onChange={({ target: { checked } }) => setIsInternationalShipping(checked)}
              value="true"
              className="checkbox appearance-none w-8 h-8 rounded-lg mr-4 border-2 border-mc-grey-500 bg-white checked:bg-check-mark"
            />
            <span className="flex-1 font-display text-sm leading-none">Envío Internacional</span>
          </label>

          {!isInternationalShipping ? null : (
            <p className="text-sm pl-4 mb-8">Se incluirán $10USD de gastos de envío al momento del pago ¯\_(ツ)_/¯</p>
          )}

          {purchaseSuccess ? null : <div className={`${!items.length ? 'opacity-50' : ''}`} id="paypal-buttons" />}
        </form>

        {/** Success message */}
        {!purchaseSuccess ? null : (
          <section className="w-full px-8 py-6 mt-10 bg-mc-blue rounded-xl text-white shadow-sm border-b-6 border-black border-opacity-20">
            <div className="flex flex-col flex-nowrap items-center mb-6">
              <StaticImage
                src="../assets/images/juanele-cartoon.png"
                alt=""
                className="w-20 rounded-full webkit-mask-image bg-white mr-6 bg-mc-blue border-2 border-white mb-2"
                placeholder="blurred"
              />

              <p className="font-display mb-2">¡Gracias por tu compra!</p>
              <p className="text-sm text-center">Recibirás un correo cuando tu pedido este en camino</p>
            </div>

            <p className="text-sm text-center">
              ¡No olvides darle like a mis redes para que más gente me dé dinero ah no... este shi!
            </p>
          </section>
        )}
      </div>
    </div>
  );
};

ShoppingCart.propTypes = {
  items: PropTypes.arrayOf(
    PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
      quantity: PropTypes.number.isRequired,
    }),
  ).isRequired,
  products: PropTypes.shape({}).isRequired,
  updateCartItem: PropTypes.func.isRequired,
  removeFromCart: PropTypes.func.isRequired,
  onPurchaseIntent: PropTypes.func.isRequired,
};

export default ShoppingCart;
