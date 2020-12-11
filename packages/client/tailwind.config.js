const plugin = require('tailwindcss/plugin');

module.exports = {
  purge: [],
  darkMode: false,
  theme: {
    colors: {
      yellow: {
        DEFAULT: '#FFC12D',
        dark: '#EEAA07',
      },
      red: {
        DEFAULT: '#FF695B',
        dark: '#D84739',
      },
    },
    fontFamily: {
      display: '"Paytone One"',
      body: 'Assistant, sans-serif',
      logo: '"Luckiest Guy"',
    },
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    plugin(({ addBase, config }) => {
      addBase({
        body: { fontFamily: config('theme.fontFamily.body') },
      });
    }),
  ],
};
