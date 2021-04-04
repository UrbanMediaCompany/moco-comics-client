require('dotenv').config({
  path: '.env',
});

module.exports = {
  siteMetadata: {
    siteUrl: `https://moco-comics.com`,
    title: `Moco-Comics`,
    description: `Toda mi vida me ha gustado hacer comics. Intento que cada librito que hago sea único, con identidad propia y mejor que el anterior, tratando de mejorar cada vez. Se ven bonitos todos juntos, ¡Cómprenmen comics!`,
    author: `@juaneletamal`,
    socials: {
      facebook: 'https://www.facebook.com/MocoComics/',
      twitter: 'https://twitter.com/JuaneleTamal',
      instagram: 'https://instagram.com/juaneletamal',
    },
  },
  plugins: [
    `gatsby-plugin-react-helmet`,
    `gatsby-plugin-image`,
    {
      resolve: `gatsby-source-filesystem`,
      options: {
        name: `images`,
        path: `${__dirname}/src/assets/images`,
      },
    },
    {
      resolve: 'gatsby-plugin-react-svg',
      options: {
        rule: {
          include: `${__dirname}/src/assets/icons`,
        },
      },
    },
    `gatsby-transformer-sharp`,
    `gatsby-plugin-sharp`,
    {
      resolve: `gatsby-plugin-manifest`,
      options: {
        name: `gatsby-starter-default`,
        short_name: `starter`,
        start_url: `/`,
        background_color: `#663399`,
        theme_color: `#663399`,
        display: `minimal-ui`,
        icon: `src/assets/favicon.png`, // This path is relative to the root of the site.
      },
    },
    `gatsby-plugin-gatsby-cloud`,
    'gatsby-plugin-eslint',
    {
      resolve: `gatsby-plugin-postcss`,
      options: {
        postCssPlugins: [require('tailwindcss'), require('autoprefixer')],
      },
    },
    {
      resolve: `gatsby-source-strapi`,
      options: {
        apiURL: process.env.STRAPI_URL,
        queryLimit: -1,
        contentTypes: ['post', 'comment', 'product'],
        singleTypes: [],
        loginData: {
          identifier: process.env.STRAPI_IDENTIFIER,
          password: process.env.STRAPI_PASSWORD,
        },
      },
    },
  ],
};
