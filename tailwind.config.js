module.exports = {
  mode: 'jit',
  purge: [
    './frontend/**/*.{js,vue}',
    './config/**/*.php',
    './templates/**/*.php',
    './plugins/**/*.php',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ]
}
