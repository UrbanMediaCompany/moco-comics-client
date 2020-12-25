module.exports = {
  siteName: 'Gridsome',
  siteUrl: 'https://moco-comics.com',
  metadata: {
    author: '@juaneletamal',
    facebookUrl: 'https://www.facebook.com/MocoComics/',
    twitterUrl: 'https://twitter.com/JuaneleTamal',
    instagramUrl: 'https://instagram.com/juaneletamal',
  },
  plugins: [
    'gridsome-plugin-tailwindcss',
    {
      use: '@gridsome/source-strapi',
      options: {
        apiURL: process.env.STRAPI_URL,
        queryLimit: 1000, // Defaults to 100
        contentTypes: ['posts'],
      },
    },
  ],
  chainWebpack: (config) => {
    const svgRule = config.module.rule('svg');
    svgRule.uses.clear();
    svgRule.use('vue-svg-loader').loader('vue-svg-loader');
  },
};
