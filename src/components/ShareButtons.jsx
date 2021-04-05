import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { graphql, useStaticQuery } from 'gatsby';
import FacebookIcon from '../assets/icons/facebook.svg';
import TwitterIcon from '../assets/icons/twitter.svg';
import ClipboardIcon from '../assets/icons/clipboard.svg';
import CheckIcon from '../assets/icons/check.svg';

const ShareButtons = ({ slug, title, characters }) => {
  const [didCopy, setDidCopy] = useState(false);
  const {
    site: {
      siteMetadata: { siteUrl, author },
    },
  } = useStaticQuery(graphql`
    query ShareButtonsQuery {
      site {
        siteMetadata {
          siteUrl
          author
        }
      }
    }
  `);

  const isClipboardAvailable = typeof window !== 'undefined' && Boolean(navigator.clipboard);
  const postUrl = `${siteUrl}/blog/${slug}`;

  const hashtags = characters
    .map((c) => c.name)
    .map((n) => n.replace(/\s/g, ''))
    .map((n) => encodeURIComponent(n))
    .join(',');

  const twitterUrl = `https://twitter.com/share?url=${postUrl}&text=${encodeURIComponent(
    `¡Échenle un ojo a "${title}"! Por ${author} en `,
  )}&hashtags=${hashtags}`;
  const facebookUrl = `https://facebook.com/sharer.php?u=${postUrl}`;

  const copyToClipboard = () => {
    navigator.clipboard
      .writeText(postUrl)
      .then(() => {
        setDidCopy(true);

        setTimeout(() => {
          setDidCopy(false);
        }, 5000);
      })
      .catch(console.error);
  };

  return (
    <section className="flex flex-npwrap justify-evenly items-center px-8 pt-8 pb-12 md:justify-end">
      <a
        href={twitterUrl}
        target="_blank"
        rel="noopener noreferrer"
        className="flex flex-col flex-nowrap items-center font-display text-sm transform hover:-rotate-6 transition-transform duration-300 md:flex-row"
      >
        <span className="inline-block bg-twitter p-3 rounded-full webkit-mask-image text-white mr-3">
          <TwitterIcon />
        </span>

        <span>Tweetear</span>
      </a>

      <a
        href={facebookUrl}
        target="_blank"
        rel="noopener noreferrer"
        className="flex flex-col flex-nowrap items-center font-display text-sm ml-8 transform hover:rotate-6 transition-transform duration-300 md:flex-row"
      >
        <span className="inline-block bg-facebook p-3 rounded-full webkit-mask-image text-white mr-3">
          <FacebookIcon />
        </span>
        <span>Compartir</span>
      </a>
      {isClipboardAvailable && didCopy ? (
        <span className="flex flex-col flex-nowrap items-center font-display text-sm ml-8 md:flex-row">
          <span className="inline-block bg-mc-yellow p-3 rounded-full webkit-mask-image text-white mr-3">
            <CheckIcon />
          </span>
          <span>¡Copiado!</span>
        </span>
      ) : (
        <button
          onClick={copyToClipboard}
          className="flex flex-col flex-nowrap items-center font-display text-sm ml-8 transform hover:-rotate-6 transition-transform duration-300 md:mt-0 md:flex-row"
        >
          <span className="inline-block bg-mc-yellow p-3 rounded-full webkit-mask-image text-white mr-3">
            <ClipboardIcon />
          </span>
          <span>Copiar link</span>
        </button>
      )}
    </section>
  );
};

ShareButtons.propTypes = {
  slug: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired,
  characters: PropTypes.arrayOf(
    PropTypes.shape({
      id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
      name: PropTypes.string.isRequired,
    }),
  ),
};

ShareButtons.defaultProps = {
  characters: [],
};

export default ShareButtons;
