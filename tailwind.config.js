const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        container: {
            center: true,
            padding: '1rem'
        },
        fontFamily: {
            sans: ['Nunito', 'sans-serif']
        },
        lineHeight: {
            0: 0,
            ...defaultTheme.lineHeight
        },
        minWidth: {
            ...defaultTheme.minWidth,
            20: '5rem',
            40: '10rem'
        },
        opacity: {
            10: '.1',
            15: '.15',
            20: '.2',
            ...defaultTheme.opacity
        },
        spacing: {
            ...defaultTheme.spacing,
            '2px': '2px',
            9: '2.25rem',
            11: '2.75rem',
            72: '18rem',
            80: '20rem',
            96: '24rem',
            128: '32rem'
        },
        zIndex: {
            ...defaultTheme.zIndex,
            1000: 1000,
            9999: 9999,
            99999: 99999,
            999999: 999999
        }
    },

    variants: {
        borderColor: ['responsive', 'hover', 'focus', 'focus-within']
    }
};
