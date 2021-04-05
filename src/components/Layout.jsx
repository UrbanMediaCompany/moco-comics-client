import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'gatsby';
import { StaticImage } from 'gatsby-plugin-image';
import HomeIcon from '../assets/icons/home.svg';
import SearchIcon from '../assets/icons/search.svg';
import ShopIcon from '../assets/icons/shopping-bag.svg';
import RSSIcon from '../assets/icons/rss.svg';
import AnchorIcon from '../assets/icons/anchor.svg';
import * as styles from './Layout.module.css';

const Layout = ({ children }) => {
  return (
    <div className="bg-mc-grey w-full min-h-screen">
      <nav className="fixed bottom-sa-3 left-4 right-4 rounded-lg bg-mc-blue py-3 shadow-lg z-10 px-constrained border-b-6 border-black border-opacity-20 md:absolute md:bottom-auto md:top-4 md:left-8 md:right-8 md:bg-transparent md:shadow-none md:border-0 md:flex md:flex-row md:flex-nowrap md:justify-between md:items-center">
        <Link to="/" className="hidden md:block">
          <StaticImage src="../assets/images/logo.png" alt="" loading="eager" quality="100" className="w-24 md:w-28" />
        </Link>

        <ul className="flex flex-row flex-nowrap justify-evenly items-center">
          <li className="md:mr-14">
            <Link
              to="/"
              className="md:hidden font-display text-sm text-white opacity-60 hover:opacity-100 transition-opacity duration-300 flex flex-col flex-nowrap items-center md:flex-row md:opacity-100 md:transform md:hover:-rotate-6 md:transition-all"
              activeClassName="opacity-100 hover:opacity-60 md:text-mc-red"
            >
              <HomeIcon />
              <span className="mt-1 md:mt-0 md:ml-6 md:text-base">Inicio</span>
            </Link>
          </li>

          {/* <li className="md:mr-14">
            <Link
              to="/buscar"
              className="font-display text-sm text-white opacity-60 hover:opacity-100 transition-opacity duration-300 flex flex-col flex-nowrap items-center md:flex-row md:opacity-100 md:transform md:hover:rotate-6 md:transition-all md:hover:text-white"
              activeClassName="opacity-100 hover:opacity-60 md:text-mc-red"
            >
              <SearchIcon />
              <span className="mt-1 md:mt-0 md:ml-6 md:text-base">Buscar</span>
            </Link>
          </li> */}

          <li>
            <Link
              to="/tienda"
              className="font-display text-sm text-white opacity-60 hover:opacity-100 transition-opacity duration-300 flex flex-col flex-nowrap items-center md:flex-row md:opacity-100 md:transform md:hover:-rotate-6 md:transition-all md:hover:text-white"
              activeClassName="opacity-100 hover:opacity-60"
            >
              <ShopIcon />
              <span className="mt-1 md:mt-0 md:ml-6 md:text-base">Tienda</span>
            </Link>
          </li>
        </ul>
      </nav>

      {children}

      <footer className="text-center">
        <div className="flex flex-col flex-nowrap justify-center items-center md:flex-row md:items-end px-3.5 md:pr-20">
          <div
            className={`${styles.bubble} relative w-11/12 max-w-prose bg-mc-red py-12 px-6 mb-10 border-b-10 border-mc-red-500 md:mb-8 md:ml-10`}
          >
            <p className="relative text-white text-sm font-bold md:text-base">
              Nací en 1982 luego de participar en la guerra de Vietnam. Tras haber estudiado cartonismo y ciencias de la
              procrastinación en la Universidad de la Sorbona en 1982, decicí salvar a los pingüinos de ellos mismos
              haciendo este comic. Es bien sabido que los pingüinos dejan de atacarse unos a otros y a su medio ambiente
              cuando están entretenidos con comics. Denme dinero.
            </p>
          </div>

          <StaticImage src="../assets/images/juanele-with-arrow.svg" alt="" className="-ml-20 md:ml-0 md:order-first" />
        </div>

        <div className="bg-mc-yellow border-b-14 border-mc-yellow-500 pt-10 px-3.5 pb-40 md:pb-6">
          <h2 className="flex flex-nowrap justify-center items-center mb-20 -ml-8 md:ml-0">
            <StaticImage src="../assets/images/logo.png" alt="" className="w-36 md:w-24 md:mr-8 mt-4" />

            <span
              className={`${styles.wordmark} font-display w-min uppercase text-3xl text-white leading-none md:w-auto`}
            >
              Moco-Comics
            </span>
          </h2>

          <nav className="max-w-4xl mx-auto mb-10">
            <ul className="flex flex-wrap justify-evenly items-center">
              {/* <li className="flex flex-nowrap items-center text-white font-display transform hover:-rotate-6 transition-all mb-8">
                <SearchIcon />
                <Link className="ml-3" to="/buscar">
                  Buscar
                </Link>
              </li> */}

              <li className="flex flex-nowrap items-center text-white font-display transform hover:rotate-6 transition-all mb-8">
                <ShopIcon />
                <Link className="ml-3" to="/tienda">
                  Tienda
                </Link>
              </li>

              <li className="flex flex-nowrap items-center text-white font-display transform hover:-rotate-6 transition-all mb-8">
                <RSSIcon />
                <a className="ml-3" href="/rss.xml">
                  RSS
                </a>
              </li>

              <li className="flex flex-nowrap items-center text-white font-display transform hover:rotate-6 transition-all mb-8">
                <AnchorIcon />
                <a className="ml-3" href="/sitemap.xml">
                  Sitemap
                </a>
              </li>
            </ul>
          </nav>

          <small className="font-bold opacity-50">
            &copy; 2013-{new Date().getFullYear()} Juan Manuel Ramírez de Arellano Niño Rincón
          </small>
        </div>
      </footer>
    </div>
  );
};

Layout.propTypes = {
  children: PropTypes.node.isRequired,
};

export default Layout;
