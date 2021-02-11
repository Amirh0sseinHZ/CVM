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
        black: '#000000',
        gray: {
            light: '#d6e0ea',
            DEFAULT: '#8798a7',
            dark: '#677580'
        },
        yellow: '#facc3b',
        red: '#E54D42',
        green: '#68CD86',
        orange: '#de8b10',
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
