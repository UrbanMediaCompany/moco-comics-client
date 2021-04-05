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
        name: `Moco-Comics`,
        short_name: `Moco-Comics`,
        start_url: `/`,
        background_color: `#ffc12d`,
        theme_color: `#ffc12d`,
        display: `minimal-ui`,
        icon: `src/assets/favicon.png`, // This path is relative to the root of the site.
      },
    },
    `gatsby-plugin-offline`,
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
    'gatsby-plugin-sitemap',
    {
      resolve: `gatsby-plugin-feed`,
      options: {
        query: `
          {
            site {
              siteMetadata {
                title
                description
                siteUrl
                site_url: siteUrl
              }
            }
          }
        `,
        feeds: [
          {
            serialize: ({ query: { site, allStrapiPost } }) => {
              return allStrapiPost.edges.map(({ node: post }) => {
                return {
                  title: post.title,
                  date: post.publishedDate,
                  description: post.content.length < 140 ? post.content : `${post.content.slice(0, 137)}...`,
                  url: `${site.siteMetadata.siteUrl}/blog/${post.slug}`,
                  guid: `${site.siteMetadata.siteUrl}/blog/${post.slug}`,
                };
              });
            },
            query: `
              {
                allStrapiPost(sort: { fields: published_at, order: DESC }) {
                  edges {
                    node {
                      slug
                      title
                      publishedDate: published_at
                      content
                    }
                  }
                }
              }
            `,
            output: '/rss.xml',
            title: 'Moco-Comics | Monitos de Juanele',
          },
        ],
      },
    },
  ],
};
