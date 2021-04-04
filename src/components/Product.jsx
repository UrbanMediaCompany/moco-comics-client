import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { GatsbyImage } from 'gatsby-plugin-image';
import ShopIcon from '../assets/icons/shopping-bag.svg';
import capitalize from '../utils/capitalize';
import formatMoney from '../utils/formatMonej';

const Product = ({ product, addToCart }) => {
  const [confirmed, setConfirmed] = useState(false);

  const handleAddToCart = () => {
    addToCart();
    setConfirmed(true);

    setTimeout(() => {
      setConfirmed(false);
    }, 2000);
  };

  return (
    <article className="flex flex-col flex-nowrap items-center md:justify-evenly">
      <div className="relative px-6 mb-8">
        <GatsbyImage
          image={product.media.localFile.childImageSharp.gatsbyImageData}
          alt=""
          className="w-full max-w-5xl border-4 border-black"
        />

        <p className="absolute -bottom-6 right-0 w-32 h-32 bg-mc-yellow text-white font-display flex justify-center items-center border-b-8 border-mc-yellow-500 rounded-full">
          <span className="">{formatMoney(product.price)}</span>
        </p>
      </div>

      <div className="w-full bg-white border-t-10 border-grey-300 rounded-lg shadow-sm overflow-hidden px-8 pb-8">
        <header className="pt-8 mb-8">
          <h2 className="font-display text-md">{product.name}</h2>
          <time dateTime={product.publishedDate} className="font-display text-grey-400">
            {capitalize(product.formattedPublishedDate)}
          </time>
        </header>

        <button
          onClick={handleAddToCart}
          type="button"
          className="group w-full max-w-xl mx-auto flex justify-center items-center bg-mc-blue text-center text-sm text-white py-2 px-4 rounded-lg font-display disabled:opacity-70 disabled:cursor-not-allowed"
          disabled={confirmed}
        >
          <ShopIcon className="mr-4 transform origin-top group-hover:rotate-12 transition-transform duration-200" />
          {confirmed ? '¡Agregado al carrito!' : '¡Lo quiero!'}
        </button>
      </div>
    </article>
  );
};

Product.propTypes = {
  product: PropTypes.shape({
    id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
    name: PropTypes.string.isRequired,
    price: PropTypes.number.isRequired,
    media: PropTypes.shape({
      localFile: PropTypes.shape({
        childImageSharp: PropTypes.shape({
          gatsbyImageData: PropTypes.object.isRequired,
        }).isRequired,
      }).isRequired,
    }).isRequired,
    publishedDate: PropTypes.string.isRequired,
    formattedPublishedDate: PropTypes.string.isRequired,
  }).isRequired,
  addToCart: PropTypes.func.isRequired,
};

export default Product;
