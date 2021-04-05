import React from 'react';
import { graphql, useStaticQuery } from 'gatsby';
import FacebookIcon from '../assets/icons/facebook.svg';
import TwitterIcon from '../assets/icons/twitter.svg';
import InstagramIcon from '../assets/icons/instagram.svg';

const SocialsNav = () => {
  const {
    site: {
      siteMetadata: { socials },
    },
  } = useStaticQuery(graphql`
    query SocialsNav {
      site {
        siteMetadata {
          socials {
            facebook
            twitter
            instagram
          }
        }
      }
    }
  `);

  return (
    <nav className="flex flex-nowrap justify-evenly items-center bg-mc-yellow rounded-xl p-4 border-b-6 border-mc-yellow-500">
      <a
        href={socials.facebook}
        rel="noreferrer noopener"
        className="text-facebook border-2 border-white bg-white rounded-full webkit-mask-image p-4 transform hover:rotate-12 transition-transform duration-300"
      >
        <FacebookIcon />
      </a>

      <a
        href={socials.twitter}
        rel="noreferrer noopener"
        className="text-twitter border-2 border-white bg-white rounded-full webkit-mask-image p-4 transform hover:-rotate-12 transition-transform duration-300"
      >
        <TwitterIcon />
      </a>

      <a
        href={socials.instagram}
        rel="noreferrer noopener"
        className="text-instagram border-2 border-white bg-white rounded-full webkit-mask-image p-4 transform hover:rotate-12 transition-transform duration-300"
      >
        <InstagramIcon />
      </a>
    </nav>
  );
};

export default SocialsNav;
