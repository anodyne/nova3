/* eslint-disable */
import preset from '../../../../vendor/filament/support/tailwind.config.preset';
const defaultTheme = require('tailwindcss/defaultTheme');
/* eslint-enable */

/** @type {import('tailwindcss').Config} */
module.exports = {
    presets: [preset],
    content: [
        './themes/pulsar/**/*.blade.php',
    ],
    safelist: [
        {
            pattern: /max-w-(lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
            variants: ['sm', 'md', 'lg', 'xl', '2xl'],
        },
        {
            pattern: /grid-cols-(1|2|3|4|5|6|7|8|9|10|11|12)/,
            variants: ['md'],
        },
        {
            pattern: /col-span-(1|2|3|4|5|6|7|8|9|10|11|12)/,
            variants: ['md'],
        },
        {
            pattern: /origin-(top|top-left|top-right|bottom|bottom-right|bottom-left)/,
            variants: ['sm', 'md', 'lg'],
        },
        {
            pattern: /left-(0|auto)/,
            variants: ['sm', 'md', 'lg'],
        },
        {
            pattern: /right-(0|auto)/,
            variants: ['sm', 'md', 'lg'],
        },
    ],
    darkMode: 'class',
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            fontFamily: {
                body: ['var(--font-body)', ...defaultTheme.fontFamily.sans],
                header: ['var(--font-header)', ...defaultTheme.fontFamily.sans],
            },
            lineHeight: {
                0: '0',
            },
            spacing: {
                'safe-top': 'env(safe-area-inset-top)',
                'safe-bottom': 'env(safe-area-inset-bottom)',
                'safe-left': 'env(safe-area-inset-left)',
                'safe-right': 'env(safe-area-inset-right)',
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        color: theme('colors.gray.600'),
                        'h1, h2, h3, h4, h5, h6': {
                            color: theme('colors.gray.900'),
                        },
                        h1: {
                            fontWeight: theme('fontWeight.extrabold'),
                        },
                        h2: {
                            fontWeight: theme('fontWeight.bold'),
                        },
                        'h3, h4': {
                            fontWeight: theme('fontWeight.semibold'),
                        },
                        'h5, h6': {
                            fontWeight: theme('fontWeight.medium'),
                        },
                        strong: {
                            fontWeight: theme('fontWeight.semibold'),
                        },
                        blockquote: {
                            color: theme('colors.gray.600'),
                            borderColor: theme('colors.gray.300'),
                        },
                    },
                },
            }),
        },
    },
    plugins: [
        /* eslint-disable */
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/container-queries'),
        /* eslint-enable */
    ],
};
