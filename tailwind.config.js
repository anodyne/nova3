const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        colors: {
            black: 'var(--color-black, #000)',
            transparent: 'transparent',
            white: 'var(--color-white, #fff)',
            danger: {
                100: 'var(--color-danger-100, #fff5f5)',
                200: 'var(--color-danger-200, #fed7d7)',
                300: 'var(--color-danger-300, #feb2b2)',
                400: 'var(--color-danger-400, #fc8181)',
                500: 'var(--color-danger-500, #f56565)',
                600: 'var(--color-danger-600, #e53e3e)',
                700: 'var(--color-danger-700, #c53030)',
                800: 'var(--color-danger-800, #9b2c2c)',
                900: 'var(--color-danger-900, #742a2a)'
            },
            gray: {
                100: 'var(--color-gray-100, #F7F7F7)',
                200: 'var(--color-gray-200, #EAEBEC)',
                300: 'var(--color-gray-300, #D1D4D7)',
                400: 'var(--color-gray-400, #BBBFC3)',
                500: 'var(--color-gray-500, #A1A5AB)',
                600: 'var(--color-gray-600, #6B6F73)',
                700: 'var(--color-gray-700, #565B5E)',
                800: 'var(--color-gray-800, #3C4348)',
                900: 'var(--color-gray-900, #283033)'
            },
            info: {
                100: 'var(--color-info-100, #faf5ff)',
                200: 'var(--color-info-200, #e9d8fd)',
                300: 'var(--color-info-300, #d6bcfa)',
                400: 'var(--color-info-400, #b794f4)',
                500: 'var(--color-info-500, #9f7aea)',
                600: 'var(--color-info-600, #805ad5)',
                700: 'var(--color-info-700, #6b46c1)',
                800: 'var(--color-info-800, #553c9a)',
                900: 'var(--color-info-900, #44337a)'
            },
            primary: {
                100: 'var(--color-primary-100, #ebf8ff)',
                200: 'var(--color-primary-200, #bee3f8)',
                300: 'var(--color-primary-300, #90cdf4)',
                400: 'var(--color-primary-400, #63b3ed)',
                500: 'var(--color-primary-500, #4299e1)',
                600: 'var(--color-primary-600, #3182ce)',
                700: 'var(--color-primary-700, #2b6cb0)',
                800: 'var(--color-primary-800, #2c5282)',
                900: 'var(--color-primary-900, #2a4365)'
            },
            success: {
                100: 'var(--color-success-100, #f0fff4)',
                200: 'var(--color-success-200, #c6f6d5)',
                300: 'var(--color-success-300, #9ae6b4)',
                400: 'var(--color-success-400, #68d391)',
                500: 'var(--color-success-500, #48bb78)',
                600: 'var(--color-success-600, #38a169)',
                700: 'var(--color-success-700, #2f855a)',
                800: 'var(--color-success-800, #276749)',
                900: 'var(--color-success-900, #22543d)'
            },
            warning: {
                100: 'var(--color-warning-100, #fffff0)',
                200: 'var(--color-warning-200, #fefcbf)',
                300: 'var(--color-warning-300, #faf089)',
                400: 'var(--color-warning-400, #f6e05e)',
                500: 'var(--color-warning-500, #ecc94b)',
                600: 'var(--color-warning-600, #d69e2e)',
                700: 'var(--color-warning-700, #b7791f)',
                800: 'var(--color-warning-800, #975a16)',
                900: 'var(--color-warning-900, #744210)'
            }
        },
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
            ...defaultTheme.maxWidth,
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
        scale: {
            0: 0,
            75: '.75',
            100: 1,
            125: '1.25'
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
        backgroundColor: ['responsive', 'hover', 'focus', 'focus-within', 'even', 'odd'],
        borderColor: ['responsive', 'hover', 'focus', 'focus-within'],
        boxShadow: ['responsive', 'hover', 'focus', 'focus-within'],
        cursor: ['hover', 'group-hover', 'focus', 'focus-within', 'disabled'],
        margin: ['responsive', 'hover', 'focus', 'first', 'last'],
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        textColor: ['responsive', 'hover', 'focus', 'focus-within']
    },

    plugins: [
        require('@kirschbaum-development/tailwindcss-scale-utilities')
    ]
};
