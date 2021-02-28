module.exports = {
  siteName: 'Moco-Comics',
  siteUrl: 'https://moco-comics.com',
  siteDescription:
    'Toda mi vida me ha gustado hacer comics. Intento que cada librito que hago sea único, con identidad propia y mejor que el anterior, tratando de mejorar cada vez. Se ven bonitos todos juntos, ¡Cómprenmen comics!',
  metadata: {
    author: '@juaneletamal',
    facebookUrl: 'https://www.facebook.com/MocoComics/',
    twitterUrl: 'https://twitter.com/JuaneleTamal',
    instagramUrl: 'https://instagram.com/juaneletamal',
  },
  templates: {
    StrapiPosts: [
      {
        path: `/blog/:slug`,
        component: `./src/templates/Post.vue`,
      },
    ],
  },
  plugins: [
    'gridsome-plugin-tailwindcss',
    '@gridsome/plugin-sitemap',
    {
      use: 'gridsome-plugin-rss',
      options: {
        contentTypeName: 'StrapiPosts',
        feedOptions: {
          title: 'Moco-Comics — Monitos de Juanele',
          feed_url: 'https://moco-comics.com/rss.xml',
          site_url: 'https://moco-comics.com',
          image_url: 'https://moco-comics.com/social-card/moco-comics.png',
          language: 'es_MX',
        },
        feedItemOptions: (node) => ({
          title: node.title,
          url: `https://moco-comics.com/blog/${node.slug}`,
          author: '@juaneletamal',
        }),
      },
    },
  ],
  chainWebpack: (config) => {
    const svgRule = config.module.rule('svg');
    svgRule.uses.clear();
    svgRule.use('vue-svg-loader').loader('vue-svg-loader');
  },
};
