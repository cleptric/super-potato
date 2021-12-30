module.exports = {
  darkMode: 'class',
  content: [
    './frontend/**/*.{js,vue}',
    './config/**/*.php',
    './templates/**/*.php',
    './plugins/**/*.php',
  ],
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
