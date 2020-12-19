module.exports = {
  siteName: 'Gridsome',
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
