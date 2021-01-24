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
        'mc-blue': 'var(--mc-color-blue)',
        grey: colors.blueGray,
        facebook: 'var(--color-facebook)',
        twitter: 'var(--color-twitter)',
        instagram: 'var(--color-instagram)',
      },
      borderWidth: {
        6: '6px',
        10: '10px',
        14: '14px',
      },
      inset: {
        'sa-3': 'calc(0.75rem + max(env(safe-area-inset-left), env(safe-area-inset-bottom)))',
      },
      gridTemplateColumns: {
        'cart-item': 'repeat(3, minmax(0, 1fr)) 3rem',
      },
      padding: {
        'sa-3': 'calc(0.75rem + max(env(safe-area-inset-left), env(safe-area-inset-bottom)))',
        constrained: 'max(1.6rem, calc((100vw - var(--inline-size-constraint)) / 2 + 1.6rem))',
      },
      height: {
        min: 'min-content',
        128: '32rem',
      },
      minWidth: {
        120: '30rem',
      },
      minHeight: {
        40: '10rem',
      },
      screens: {
        xs: '414px',
      },
      backgroundImage: {
        'check-mark': `url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='black' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e")`,
      },
    },
  },
  variants: {
    extend: {
      borderWidth: ['last'],
      margin: ['first'],
      backgroundClip: ['hover', 'focus'],
      backgroundColor: ['checked'],
      backgroundOpacity: ['checked'],
      backgroundImage: ['checked'],
      borderColor: ['checked'],
      borderStyle: ['hover', 'focus', 'focus-within'],
      rotate: ['group-hover'],
      cursor: ['disabled'],
      opacity: ['disabled'],
    },
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
          '--mc-color-blue': '#5295ff',
          '--color-facebook': '#415a93',
          '--color-twitter': '#4aa0ec',
          '--color-instagram': '#d0426d',
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
        },
      });
    }),
  ],
};
