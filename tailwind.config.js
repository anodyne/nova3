const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: '#000',
            white: '#fff',
            blue: colors.lightBlue,
            gray: colors.coolGray,
            green: colors.green,
            purple: colors.purple,
            red: colors.red,
            yellow: colors.amber,
            orange: colors.orange
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
