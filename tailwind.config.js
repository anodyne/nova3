const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        colors: {
            black: 'var(--color-black, #000)',
            transparent: 'transparent',
            white: 'var(--color-white, #fff)',
            danger: {
                50: 'var(--color-danger-50, #fdf2f2)',
                100: 'var(--color-danger-100, #fde8e8)',
                200: 'var(--color-danger-200, #fbd5d5)',
                300: 'var(--color-danger-300, #f8b4b4)',
                400: 'var(--color-danger-400, #f98080)',
                500: 'var(--color-danger-500, #f05252)',
                600: 'var(--color-danger-600, #e02424)',
                700: 'var(--color-danger-700, #c81e1e)',
                800: 'var(--color-danger-800, #9b1c1c)',
                900: 'var(--color-danger-900, #771d1d)'
            },
            gray: {
                50: 'var(--color-gray-50, #f9fafb)',
                100: 'var(--color-gray-100, #f4f5f7)',
                200: 'var(--color-gray-200, #e5e7eb)',
                300: 'var(--color-gray-300, #d2d6dc)',
                400: 'var(--color-gray-400, #9fa6b2)',
                500: 'var(--color-gray-500, #6b7280)',
                600: 'var(--color-gray-600, #4b5563)',
                700: 'var(--color-gray-700, #374151)',
                800: 'var(--color-gray-800, #252f3f)',
                900: 'var(--color-gray-900, #161e2e)'
            },
            info: {
                50: 'var(--color-info-50, #f6f5ff)',
                100: 'var(--color-info-100, #edebfe)',
                200: 'var(--color-info-200, #dcd7fe)',
                300: 'var(--color-info-300, #cabffd)',
                400: 'var(--color-info-400, #ac94fa)',
                500: 'var(--color-info-500, #9061f9)',
                600: 'var(--color-info-600, #7e3af2)',
                700: 'var(--color-info-700, #6c2bd9)',
                800: 'var(--color-info-800, #5521b5)',
                900: 'var(--color-info-900, #4a1d96)'
            },
            primary: {
                50: 'var(--color-primary-50, #ebf5ff)',
                100: 'var(--color-primary-100, #e1effe)',
                200: 'var(--color-primary-200, #c3ddfd)',
                300: 'var(--color-primary-300, #a4cafe)',
                400: 'var(--color-primary-400, #76a9fa)',
                500: 'var(--color-primary-500, #3f83f8)',
                600: 'var(--color-primary-600, #1c64f2)',
                700: 'var(--color-primary-700, #1a56db)',
                800: 'var(--color-primary-800, #1e429f)',
                900: 'var(--color-primary-900, #233876)'
            },
            success: {
                50: 'var(--color-success-50, #f3faf7)',
                100: 'var(--color-success-100, #def7ec)',
                200: 'var(--color-success-200, #bcf0da)',
                300: 'var(--color-success-300, #84e1bc)',
                400: 'var(--color-success-400, #31c48d)',
                500: 'var(--color-success-500, #0e9f6e)',
                600: 'var(--color-success-600, #057a55)',
                700: 'var(--color-success-700, #046c4e)',
                800: 'var(--color-success-800, #03543f)',
                900: 'var(--color-success-900, #014737)'
            },
            warning: {
                50: 'var(--color-warning-50, #f3faf7)',
                100: 'var(--color-warning-100, #def7ec)',
                200: 'var(--color-warning-200, #bcf0da)',
                300: 'var(--color-warning-300, #84e1bc)',
                400: 'var(--color-warning-400, #31c48d)',
                500: 'var(--color-warning-500, #0e9f6e)',
                600: 'var(--color-warning-600, #057a55)',
                700: 'var(--color-warning-700, #046c4e)',
                800: 'var(--color-warning-800, #03543f)',
                900: 'var(--color-warning-900, #014737)'
            }
        },
        container: {
            center: true,
            padding: '1rem'
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
        spacing: {
            ...defaultTheme.spacing,
            '2px': '2px',
            7: '1.75rem',
            9: '2.25rem',
            11: '2.75rem',
            60: '15rem',
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
        borderRadius: ['responsive', 'hover', 'focus', 'first', 'last'],
        borderWidth: ['responsive', 'first', 'last'],
        boxShadow: ['responsive', 'hover', 'focus', 'focus-within'],
        cursor: ['hover', 'group-hover', 'focus', 'focus-within', 'disabled'],
        margin: ['responsive', 'hover', 'focus', 'first', 'last'],
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        textColor: ['responsive', 'hover', 'focus', 'focus-within']
    },

    plugins: [
        /* eslint-disable */
        require('@tailwindcss/ui')({
            layout: 'sidebar'
        }),
        require('./nova/resources/js/tailwind-plugins/flexbox-grid')()
        /* eslint-enable */
    ]
};
