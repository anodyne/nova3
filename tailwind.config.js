const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        container: {
            center: true,
            padding: '1rem'
        },
        extend: {
            colors: {
                transparent: 'transparent'
            },
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans]
            },
            lineHeight: {
                0: 0
            },
            minHeight: defaultTheme.spacing,
            opacity: {
                95: '.95'
            },
            spacing: {
                '2px': '2px'
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
        require('@tailwindcss/ui')({
            layout: 'sidebar'
        }),
        require('@tailwindcss/typography'),
        require('tailwindcss-interaction-variants'),
        /* eslint-enable */
    ],

    dark: 'class',

    experimental: {
        darkModeVariant: false,
        defaultLineHeights: true,
        extendedFontSizeScale: true,
        extendedSpacingScale: true,
        uniformColorPalette: true
    },

    future: {
        purgeLayersByDefault: true,
        removeDeprecatedGapUtilities: true
    }
};
