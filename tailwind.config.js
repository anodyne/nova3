/* eslint-disable */
const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');
const { default: flattenColorPalette } = require('tailwindcss/lib/util/flattenColorPalette');

const scale = Array.from({ length: 12 }, (_, i) => i + 1);

const createColorScale = (color) => ({
    [color]: Object.assign(
        {},
        ...scale.map((s) => ({
            [s]: ({ opacityVariable, opacityValue }) => {
                if (opacityValue !== undefined) {
                    return `hsla(var(--${color}${s}), ${opacityValue})`;
                }
                if (opacityVariable !== undefined) {
                    return `hsla(var(--${color}${s}), var(${opacityVariable}, 1))`;
                }
                return `hsl(var(--${color}${s}))`;
            },
        })),
    ),
});
/* eslint-enable */

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './nova/resources/**/*.{js,ts,blade.php,css}',
        './nova/foundation/View/Components/*.php',
        './nova/vendor/livewire-ui/modal/resources/views/*.blade.php',
        './storage/framework/views/*.php',
    ],
    safelist: [
        'max-w-none',
        'text-warning-400',
        'text-[#f2634c]',
        'text-[#f99c26]',
        'text-[#130f32]',
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
        {
            pattern: /border-(primary|error)-(500)/,
            variants: ['sm', 'md', 'lg'],
        },
        {
            pattern: /bg-(primary|error|gray)-(500)/,
            variants: ['sm', 'md', 'lg'],
        },
        {
            pattern: /bg-preview-(moss|green-light|green|emerald|teal|cyan|blue-light|blue|blue-dark|indigo|violet|lilac|purple|fuchsia|pink|rose|red|international-orange|orange|amber|yellow|green-monster|gray|gray-blue|gray-cool|gray-modern|gray-neutral|gray-iron|gray-true|gray-warm)/,
            variants: [],
        },
    ],
    darkMode: 'class',
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            colors: {
                gray: {
                    25: 'rgb(var(--color-gray-25) / <alpha-value>)',
                    50: 'rgb(var(--color-gray-50) / <alpha-value>)',
                    100: 'rgb(var(--color-gray-100) / <alpha-value>)',
                    200: 'rgb(var(--color-gray-200) / <alpha-value>)',
                    300: 'rgb(var(--color-gray-300) / <alpha-value>)',
                    400: 'rgb(var(--color-gray-400) / <alpha-value>)',
                    500: 'rgb(var(--color-gray-500) / <alpha-value>)',
                    600: 'rgb(var(--color-gray-600) / <alpha-value>)',
                    700: 'rgb(var(--color-gray-700) / <alpha-value>)',
                    800: 'rgb(var(--color-gray-800) / <alpha-value>)',
                    900: 'rgb(var(--color-gray-900) / <alpha-value>)',
                },
                primary: {
                    25: 'rgb(var(--color-primary-25) / <alpha-value>)',
                    50: 'rgb(var(--color-primary-50) / <alpha-value>)',
                    100: 'rgb(var(--color-primary-100) / <alpha-value>)',
                    200: 'rgb(var(--color-primary-200) / <alpha-value>)',
                    300: 'rgb(var(--color-primary-300) / <alpha-value>)',
                    400: 'rgb(var(--color-primary-400) / <alpha-value>)',
                    500: 'rgb(var(--color-primary-500) / <alpha-value>)',
                    600: 'rgb(var(--color-primary-600) / <alpha-value>)',
                    700: 'rgb(var(--color-primary-700) / <alpha-value>)',
                    800: 'rgb(var(--color-primary-800) / <alpha-value>)',
                    900: 'rgb(var(--color-primary-900) / <alpha-value>)',
                },
                error: {
                    25: 'rgb(var(--color-error-25) / <alpha-value>)',
                    50: 'rgb(var(--color-error-50) / <alpha-value>)',
                    100: 'rgb(var(--color-error-100) / <alpha-value>)',
                    200: 'rgb(var(--color-error-200) / <alpha-value>)',
                    300: 'rgb(var(--color-error-300) / <alpha-value>)',
                    400: 'rgb(var(--color-error-400) / <alpha-value>)',
                    500: 'rgb(var(--color-error-500) / <alpha-value>)',
                    600: 'rgb(var(--color-error-600) / <alpha-value>)',
                    700: 'rgb(var(--color-error-700) / <alpha-value>)',
                    800: 'rgb(var(--color-error-800) / <alpha-value>)',
                    900: 'rgb(var(--color-error-900) / <alpha-value>)',
                },
                warning: {
                    25: 'rgb(var(--color-warning-25) / <alpha-value>)',
                    50: 'rgb(var(--color-warning-50) / <alpha-value>)',
                    100: 'rgb(var(--color-warning-100) / <alpha-value>)',
                    200: 'rgb(var(--color-warning-200) / <alpha-value>)',
                    300: 'rgb(var(--color-warning-300) / <alpha-value>)',
                    400: 'rgb(var(--color-warning-400) / <alpha-value>)',
                    500: 'rgb(var(--color-warning-500) / <alpha-value>)',
                    600: 'rgb(var(--color-warning-600) / <alpha-value>)',
                    700: 'rgb(var(--color-warning-700) / <alpha-value>)',
                    800: 'rgb(var(--color-warning-800) / <alpha-value>)',
                    900: 'rgb(var(--color-warning-900) / <alpha-value>)',
                },
                success: {
                    25: 'rgb(var(--color-success-25) / <alpha-value>)',
                    50: 'rgb(var(--color-success-50) / <alpha-value>)',
                    100: 'rgb(var(--color-success-100) / <alpha-value>)',
                    200: 'rgb(var(--color-success-200) / <alpha-value>)',
                    300: 'rgb(var(--color-success-300) / <alpha-value>)',
                    400: 'rgb(var(--color-success-400) / <alpha-value>)',
                    500: 'rgb(var(--color-success-500) / <alpha-value>)',
                    600: 'rgb(var(--color-success-600) / <alpha-value>)',
                    700: 'rgb(var(--color-success-700) / <alpha-value>)',
                    800: 'rgb(var(--color-success-800) / <alpha-value>)',
                    900: 'rgb(var(--color-success-900) / <alpha-value>)',
                },
                info: {
                    25: 'rgb(var(--color-info-25) / <alpha-value>)',
                    50: 'rgb(var(--color-info-50) / <alpha-value>)',
                    100: 'rgb(var(--color-info-100) / <alpha-value>)',
                    200: 'rgb(var(--color-info-200) / <alpha-value>)',
                    300: 'rgb(var(--color-info-300) / <alpha-value>)',
                    400: 'rgb(var(--color-info-400) / <alpha-value>)',
                    500: 'rgb(var(--color-info-500) / <alpha-value>)',
                    600: 'rgb(var(--color-info-600) / <alpha-value>)',
                    700: 'rgb(var(--color-info-700) / <alpha-value>)',
                    800: 'rgb(var(--color-info-800) / <alpha-value>)',
                    900: 'rgb(var(--color-info-900) / <alpha-value>)',
                },
                preview: {
                    gray: '#667085',
                    'gray-blue': '#4e5ba6',
                    'gray-cool': '#5d6b98',
                    'gray-modern': '#697586',
                    'gray-neutral': '#6c737f',
                    'gray-iron': '#70707b',
                    'gray-true': '#737373',
                    'gray-warm': '#79716b',
                    moss: '#669f2a',
                    'green-light': '#66c61c',
                    green: '#16b364',
                    teal: '#15b79e',
                    cyan: '#06aed4',
                    'blue-light': '#0ba5ec',
                    blue: '#2e90fa',
                    'blue-dark': '#2970ff',
                    indigo: '#6172f3',
                    violet: '#875bf7',
                    purple: '#7a5af8',
                    fuchsia: '#d444f1',
                    pink: '#ee46bc',
                    rose: '#f63d68',
                    'international-orange': '#f04a00',
                    orange: '#ef6820',
                    yellow: '#eaaa08',
                    emerald: '#12b76a',
                    amber: '#f79009',
                    red: '#f04438',
                    lilac: '#9e77ed',
                    'green-monster': '#54796d',
                },
            },
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            lineHeight: {
                0: '0',
            },
            minHeight: defaultTheme.spacing,
            screens: {
                standalone: { raw: '(display-mode: standalone)' },
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
        require("@tailwindcss/forms")({
            strategy: 'class',
        }),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    highlight: (value) => ({ boxShadow: `inset 0 1px 0 0 ${value}` }),
                },
                { values: flattenColorPalette(theme('backgroundColor')), type: 'color' }
            )
        },
        /* eslint-enable */
    ],
};
