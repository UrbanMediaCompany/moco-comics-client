const plugin = require('tailwindcss/plugin');
const colors = require('tailwindcss/colors');

module.exports = {
  purge: [],
  darkMode: false,
  theme: {
    fontFamily: {
      display: 'var(--font-family-display)',
      body: 'var(--font-family-body)',
      cartoon: 'var(--font-family-cartoon)',
    },
    fontSize: {
      xs: 'var(--font-size-xs)',
      sm: 'var(--font-size-sm)',
      base: 'var(--font-size-base)',
      lg: 'var(--font-size-lg)',
      xl: 'var(--font-size-xl)',
      '2xl': 'var(--font-size-2xl)',
      '3xl': 'var(--font-size-3xl)',
      '4xl': 'var(--font-size-4xl)',
    },
    extend: {
      colors: {
        'mc-yellow': {
          DEFAULT: 'var(--mc-color-yellow)',
          500: 'var(--mc-color-yellow-500)',
        },
        'mc-red': {
          DEFAULT: 'var(--mc-color-red)',
          500: 'var(--mc-color-red-500)',
        },
        'mc-grey': 'var(--mc-color-grey)',
        grey: colors.blueGray,
      },
      borderWidth: {
        6: '6px',
        10: '10px',
      },
      inset: {
        'sa-3': 'calc(0.75rem + max(env(safe-area-inset-left), env(safe-area-inset-bottom)))',
      },
      gridTemplateColumns: {
        blog: 'minmax(400px, 640px) min-content',
      },
      padding: {
        constrained: 'max(1rem, calc((100vw - var(--inline-size-constraint)) / 2 + 1rem))',
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    plugin(({ addBase, config }) => {
      addBase({
        ':root': {
          '--mc-color-yellow': '#ffc12d',
          '--mc-color-yellow-500': '#eeaa07',
          '--mc-color-red': '#ff695b',
          '--mc-color-red-500': '#d84739',
          '--mc-color-grey': '#f1f5f9',
          '--font-family-display': '"Paytone One"',
          '--font-family-body': 'Assistant, sans-serif',
          '--font-family-cartoon': '"Luckiest Guy"',
          // Perfect Fourth Scale
          '--font-size-xs': '1rem',
          '--font-size-sm': '1.333rem',
          '--font-size-base': '1.777rem',
          '--font-size-lg': '2.368rem',
          '--font-size-xl': '3.157rem',
          '--font-size-2xl': '4.209rem',
          '--font-size-3xl': '5.61rem',
          '--font-size-4xl': '7.478rem',
          '--inline-size-constraint': '1600px',
        },
        html: {
          overflowX: 'hidden',
          fontSize: '62.5%',
          scrollBehavior: 'smooth',
        },
        body: {
          textRendering: 'optimizeLegibility',
          '-webkit-font-smoothing': 'antialiased',
          '-moz-osx-font-smoothing': 'grayscale',
          fontSmoothing: config('theme.fontSmoothing.antialiased'),
          fontFamily: config('theme.fontFamily.body'),
          fontSize: config('theme.fontSize.base'),
          overflowX: 'hidden',
        },
      });
    }),
  ],
};
