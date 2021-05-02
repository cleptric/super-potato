module.exports = {
  mode: 'jit',
  purge: [
    './frontend/**/*.{js,vue}',
    './templates/**/*.php',
    './plugins/**/*.php',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      rotate: {
        '40': '40deg',
        '-40': '-40deg',
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ]
}
