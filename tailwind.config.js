const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        borderRadius: {
            ...defaultTheme.borderRadius,
            sm: '.1875rem',
            default: '.375rem',
            lg: '.75rem'
        },
        container: {
            center: true,
            padding: '1rem'
        },
        lineHeight: {
            0: 0,
            ...defaultTheme.lineHeight
        },
        spacing: {
            ...defaultTheme.spacing,
            '2px': '2px',
            11: '2.75rem',
            72: '18rem',
            80: '20rem',
            96: '24rem',
            128: '32rem'
        },
        zIndex: {
            ...defaultTheme.zIndex,
            1000: 1000
        }
    }
};
