import { graphql } from 'gatsby';
import React, { useState } from 'react';
import PropTypes from 'prop-types';
import Layout from '../components/Layout';
import SocialsNav from '../components/SocialsNav';
import * as styles from '../styles/Tienda.module.css';
import Product from '../components/Product';
import ShoppingCart from '../components/ShoppingCart';
import SEO from '../components/SEO';

const StorePage = ({ path, data: { allStrapiProduct } }) => {
  const [cart, setCart] = useState([]);
  const [isPayingWithCard, setIsPayingWithCard] = useState(false);

  const products = allStrapiProduct.edges.map(({ node }) => node);
  const normalizedProducts = products.reduce((acc, p) => {
    acc[p.id] = p;
    return acc;
  }, {});

  const addToCart = (item) => {
    const cartMatch = cart.find((i) => i.id === item);

    if (!cartMatch) {
      setCart([...cart, { id: item, quantity: 1 }]);
      return;
    }

    setCart(cart.map((i) => (i.id === item ? { id: item, quantity: i.quantity + 1 } : i)));
  };

  const updateCartItem = ({ id, quantity }) => {
    setCart(cart.map((i) => (i.id === id ? { id, quantity } : i)));
  };

  const removeFromCart = (item) => {
    setCart(cart.filter((i) => i.id !== item));
  };

  const adaptLayoutToPaymentMethod = (method) => {
    setIsPayingWithCard(method === 'card');
    const { matches: isMediumViewport } = window.matchMedia('(min-width: 768px)');

    if (!isPayingWithCard || !isMediumViewport) return;

    window.scrollTo({
      top: 280,
      left: 0,
    });
  };

  return (
    <Layout>
      <SEO title="Tienda" pathname={path} />

      <header
        className={`${styles.hero} relative w-full bg-mc-yellow pt-28 pb-32 px-constrained text-left overflow-hidden md:pt-44`}
      >
        <div className="flex flex-col flex-nowrap relative mb-12 max-w-7xl mx-auto">
          <h1 className={`${styles.title} font-display opacity-95 text-white text-3xl leading-none mb-12`}>
            ¡Hartos cómics para llevar!
          </h1>
          <p className="font-cartoon opacity-90 text-white text-lg">¡Llévele, llévele!</p>
        </div>
      </header>

      <main className={`${styles.main} px-constrained -mt-20 grid gap-20 md:pb-64`}>
        <section className={`${styles.shelf} w-full grid grid-cols-1 gap-16 pb-20 relative`}>
          {products.map((product) => (
            <Product product={product} addToCart={() => addToCart(product.id)} key={product.id} />
          ))}
        </section>

        <aside className={`pb-48 md:-top-4 md:h-min ${isPayingWithCard ? 'md:relative' : 'md:sticky'}`}>
          <ShoppingCart
            items={cart}
            products={normalizedProducts}
            updateCartItem={updateCartItem}
            removeFromCart={removeFromCart}
            onPurchaseIntent={adaptLayoutToPaymentMethod}
          />

          <SocialsNav />
        </aside>
      </main>
    </Layout>
  );
};

StorePage.propTypes = {
  path: PropTypes.string.isRequired,
  data: PropTypes.shape({
    allStrapiProduct: PropTypes.shape({
      edges: PropTypes.arrayOf(
        PropTypes.shape({
          node: PropTypes.shape({
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
        }),
      ).isRequired,
    }).isRequired,
  }).isRequired,
};

export default StorePage;

export const query = graphql`
  query StorePageQuery {
    allStrapiProduct(sort: { fields: created_at, order: DESC }) {
      edges {
        node {
          id: strapiId
          name
          price
          media {
            localFile {
              childImageSharp {
                gatsbyImageData(placeholder: DOMINANT_COLOR, layout: CONSTRAINED, width: 640)
              }
            }
            url
          }
          publishedDate: published_at
          formattedPublishedDate: published_at(formatString: "MMMM D, YYYY", locale: "es-MX")
        }
      }
    }
  }
`;
