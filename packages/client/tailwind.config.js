const plugin = require('tailwindcss/plugin');
const colors = require('tailwindcss/colors');

module.exports = {
  purge: [],
  darkMode: false,
  theme: {
    fontFamily: {
      display: '"Paytone One"',
      body: 'Assistant, sans-serif',
      logo: '"Luckiest Guy"',
    },
    extend: {
      colors: {
        'mc-yellow': {
          DEFAULT: '#FFC12D',
          500: '#EEAA07',
        },
        'mc-red': {
          DEFAULT: '#FF695B',
          500: '#D84739',
        },
        'mc-grey': colors.blueGray,
      },
    },
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
