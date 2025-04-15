/* eslint-disable */
const defaultTheme = require('tailwindcss/defaultTheme');
/* eslint-enable */

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './nova/resources/views/maintenance.blade.php',
    ],
    darkMode: 'class',
    theme: {
        fontFamily: {
            sans: ['Inter', ...defaultTheme.fontFamily.sans],
            title: ['Geist', ...defaultTheme.fontFamily.sans],
        },
    },
    plugins: [],
};
