const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: '#000',
            white: '#fff',
            // blue: colors.lightBlue,
            gray: colors.coolGray,
            // green: colors.green,
            // purple: colors.purple,
            // red: colors.red,
            // yellow: colors.amber,
            // orange: colors.orange,

            green: {
                50: '#f2fbf9',
                100: '#e6f7f3',
                200: '#bfebe0',
                300: '#99dfcd',
                400: '#4dc8a8',
                500: '#00B082',
                600: '#009e75',
                700: '#008462',
                800: '#006a4e',
                900: '#005640'
            },
            blue: {
                50: '#f5fbff',
                100: '#ebf7ff',
                200: '#ccebff',
                300: '#addeff',
                400: '#70c6ff',
                500: '#33ADFF',
                600: '#2e9ce6',
                700: '#2682bf',
                800: '#1f6899',
                900: '#19557d'
            },
            purple: {
                50: '#faf5ff',
                100: '#f6ebff',
                200: '#e8ccff',
                300: '#d9adff',
                400: '#bd70ff',
                500: '#A133FF',
                600: '#912ee6',
                700: '#7926bf',
                800: '#611f99',
                900: '#4f197d'
            },
            yellow: {
                50: '#fffcf8',
                100: '#fff9f0',
                200: '#ffefda',
                300: '#ffe5c3',
                400: '#ffd296',
                500: '#FFBF69',
                600: '#e6ac5f',
                700: '#bf8f4f',
                800: '#99733f',
                900: '#7d5e33'
            },
            orange: {
                50: '#fffaf8',
                100: '#fff6f0',
                200: '#ffe8da',
                300: '#ffdac3',
                400: '#ffbf96',
                500: '#FFA369',
                600: '#e6935f',
                700: '#bf7a4f',
                800: '#99623f',
                900: '#7d5033'
            },
            red: {
                50: '#fff5f6',
                100: '#ffebed',
                200: '#ffcdd3',
                300: '#ffafb9',
                400: '#ff7484',
                500: '#FF384F',
                600: '#e63247',
                700: '#bf2a3b',
                800: '#99222f',
                900: '#7d1b27'
            }
        },
        container: {
            center: true,
            padding: '1rem'
        },
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans]
            },
            lineHeight: {
                0: 0
            },
            minHeight: defaultTheme.spacing,
            screens: {
                standalone: { raw: '(display-mode: standalone)' }
            },
            spacing: {
                'safe-top': 'env(safe-area-inset-top)',
                'safe-bottom': 'env(safe-area-inset-bottom)',
                'safe-left': 'env(safe-area-inset-left)',
                'safe-right': 'env(safe-area-inset-right)'
            },
            zIndex: {
                99: 99,
                999: 999,
                1000: 1000,
                9999: 9999,
                99999: 99999,
                999999: 999999
            }
        }
    },

    variants: {
        backgroundColor: ({ after }) => after(['group-hover', 'group-focus', 'focus-within', 'active', 'even', 'odd']),
        borderColor: ({ after }) => after(['group-hover', 'group-focus', 'focus-within']),
        borderRadius: ({ after }) => after(['first', 'last']),
        borderWidth: ({ after }) => after(['first', 'last']),
        boxShadow: ({ after }) => after(['focus-within']),
        cursor: ({ after }) => after(['disabled']),
        margin: ({ after }) => after(['first', 'last']),
        opacity: ({ after }) => after(['disabled']),
        textColor: ({ after }) => after(['group-hover', 'group-focus', 'focus-within', 'active', 'group-focus-within']),
        visibility: ({ after }) => after(['group-hover'])
    },

    plugins: [
        /* eslint-disable */
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('tailwindcss-interaction-variants'),
        /* eslint-enable */
    ],

    darkMode: 'class'
};
