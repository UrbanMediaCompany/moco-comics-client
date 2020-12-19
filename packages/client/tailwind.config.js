const plugin = require('tailwindcss/plugin');
const colors = require('tailwindcss/colors');

module.exports = {
  purge: [],
  darkMode: false,
  theme: {
    fontFamily: {
      display: '"Paytone One"',
      body: 'Assistant, sans-serif',
      cartoon: '"Luckiest Guy"',
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
      borderWidth: {
        6: '6px',
      },
      inset: {
        'sa-2': 'calc(0.5rem + max(env(safe-area-inset-left), env(safe-area-inset-bottom)))',
      },
      gridTemplateColumns: {
        blog: 'minmax(400px, 640px) min-content',
      },
      padding: {
        constrained: 'max(0.8rem, calc((100vw - 1400px) / 2 + 0.8rem))',
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
