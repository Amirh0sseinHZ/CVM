module.exports = {
  purge: [
      './storage/framework/views/*.php',
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
        transparent: 'transparent',
        current: 'currentColor',
        white: '#ffffff',
        gray: '#8798A7',
        yellow: '#ffe593',
        blue: {
            lighter: '#1DA2F2',
            light: '#1C91DA',
            DEFAULT: '#173045',
            dark: '#15202B'
        }
    }
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
