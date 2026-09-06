/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './src/pages/**/*.{js,ts,jsx,tsx,mdx}',
    './src/components/**/*.{js,ts,jsx,tsx,mdx}',
    './src/app/**/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      colors: {
        background: '#F5EFE2',
        foreground: '#241B16',
        songket: {
          red: '#7A1F2B',
          gold: '#C9A227',
          dark: '#3D0F15'
        },
      },
      fontFamily: {
        serif: ['var(--font-playfair-display)', 'serif'],
        sans: ['var(--font-inter)', 'sans-serif'],
      },
      spacing: {
        'gonjong': '2rem',
      },
      maxWidth: {
        'content': '80ch',
      },
    },
  },
  plugins: [],
}
