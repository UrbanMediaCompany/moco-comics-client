module.exports = {
  siteName: 'Gridsome',
  plugins: ['gridsome-plugin-tailwindcss'],
  chainWebpack: (config) => {
    const svgRule = config.module.rule('svg');
    svgRule.uses.clear();
    svgRule.use('vue-svg-loader').loader('vue-svg-loader');
  },
};
