import React from 'react';
import PropTypes from 'prop-types';
import { Helmet } from 'react-helmet';
import { useStaticQuery, graphql } from 'gatsby';

function SEO({ children, lang, canonical, title, description, image, imageAlt, og }) {
  const {
    site: { siteMetadata },
  } = useStaticQuery(
    graphql`
      query {
        site {
          siteMetadata {
            title
            siteUrl
            description
            author
          }
        }
      }
    `,
  );

  const canonicalUrl = `${siteMetadata.siteUrl}${canonical}`;
  const canonicalTitle = title ? `${title} | ${siteMetadata.title}` : `${siteMetadata.title} | Monitos de Juanele`;

  return (
    <Helmet>
      <html lang={lang} dir="ltr" />
      <title>{canonicalTitle}</title>

      <meta name="description" content={description || siteMetadata.description} />

      <link rel="canonical" href={canonicalUrl} />

      <meta property="og:type" content={og.type || 'website'} />
      <meta property="og:site_name" content={siteMetadata.title} />
      <meta property="og:title" content={canonicalTitle} />
      <meta property="og:description" content={description || siteMetadata.description} />
      <meta property="og:image" content={`${siteMetadata.siteUrl}${image}`} />
      <meta property="og:image:type" content="image/png" />
      <meta property="og:image:width" content="1280" />
      <meta property="og:image:height" content="669" />
      <meta property="og:image:alt" content={imageAlt} />
      <meta property="og:url" content={canonicalUrl} />
      <meta property="og:locale" content="es_MX" />
      {og.type === 'article' && (
        <meta property="article:published_time" content={new Date(og.published_time).toISOString()} />
      )}
      {og.type === 'article' && <meta property="article:author" content={siteMetadata.author} />}
      {og.type === 'article' && <meta property="og:section" content={og.section} />}
      {og.type === 'article' && og.tags.map((t, i) => <meta property="og:tag" content={t} key={i} />)}

      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:site:id" content={siteMetadata.author} />
      <meta name="twitter:creator" content={siteMetadata.author} />
      <meta name="twitter:title" content={canonicalTitle} />
      <meta name="twitter:description" content={description || siteMetadata.description} />
      <meta name="twitter:image" content={`${siteMetadata.siteUrl}${image}`} />
      <meta name="twitter:image_alt" content={imageAlt} />
      <meta name="twitter:url" content={canonicalUrl} />

      {children}
    </Helmet>
  );
}

SEO.propTypes = {
  children: PropTypes.node,
  lang: PropTypes.string,
  canonical: PropTypes.string,
  title: PropTypes.string,
  description: PropTypes.string,
  image: PropTypes.string,
  imageAlt: PropTypes.string,
  og: PropTypes.shape({
    type: PropTypes.oneOf(['website', 'article']),
    published_time: PropTypes.string,
    section: PropTypes.string,
    tags: PropTypes.arrayOf(PropTypes.string),
  }),
};

SEO.defaultProps = {
  children: null,
  lang: 'es',
  canonical: '',
  title: '',
  description: '',
  image: '/social-card/moco-comics.png',
  imageAlt: '',
  og: { type: 'website' },
};

export default SEO;
