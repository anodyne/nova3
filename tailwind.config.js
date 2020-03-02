const defaultTheme = require('tailwindcss/defaultTheme');
const rgba = require('hex-to-rgba');
const colors = require('@tailwindcss/ui/colors');

module.exports = {
    theme: {
        container: {
            center: true,
            padding: '1rem'
        },
        extend: {
            boxShadow: theme => ({
                'outline-danger': `0 0 0 3px ${rgba(theme('colors.danger.300'), 0.45)}`,
                'outline-info': `0 0 0 3px ${rgba(theme('colors.info.300'), 0.45)}`,
                'outline-primary': `0 0 0 3px ${rgba(theme('colors.primary.300'), 0.45)}`,
                'outline-success': `0 0 0 3px ${rgba(theme('colors.success.300'), 0.45)}`,
                'outline-warning': `0 0 0 3px ${rgba(theme('colors.warning.300'), 0.45)}`
            }),
            colors: {
                transparent: 'transparent',
                danger: colors.red,
                info: colors.purple,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow
            },
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans]
            },
            lineHeight: {
                0: 0
            },
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
        backgroundColor: ['responsive', 'group-hover', 'hover', 'group-focus', 'focus-within', 'focus', 'active', 'even', 'odd'],
        borderColor: ['responsive', 'group-hover', 'hover', 'group-focus', 'focus-within', 'focus'],
        borderRadius: ['responsive', 'hover', 'focus', 'first', 'last'],
        borderWidth: ['responsive', 'first', 'last'],
        boxShadow: ['responsive', 'hover', 'focus', 'focus-within'],
        cursor: ['hover', 'group-hover', 'focus', 'focus-within', 'disabled'],
        margin: ['responsive', 'hover', 'focus', 'first', 'last'],
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        textColor: ['responsive', 'group-hover', 'hover', 'group-focus', 'focus-within', 'focus', 'active']
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
