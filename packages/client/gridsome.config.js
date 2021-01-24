module.exports = {
  siteName: 'Gridsome',
  siteUrl: 'https://moco-comics.com',
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
  plugins: ['gridsome-plugin-tailwindcss'],
  chainWebpack: (config) => {
    const svgRule = config.module.rule('svg');
    svgRule.uses.clear();
    svgRule.use('vue-svg-loader').loader('vue-svg-loader');
  },
};
