/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        "black": "#34364a",
        "primary": "#506FFF",
        "success": "#22C58B",
        "secondary": "#E5E9F2",
        "secondary-2": "#E5E9F2",
        "gold": "#F4A42B"
      }
    },
  },
  plugins: [
    require("daisyui")
  ],
}

