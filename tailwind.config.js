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
        './nova/vendor/filament/**/*.blade.php',
        './nova/vendor/livewire-ui/modal/resources/views/*.blade.php',
        './nova/vendor/rawilk/laravel-form-components/src/**/*.php',
        './nova/vendor/rawilk/laravel-form-components/resources/**/*.php',
        './nova/vendor/rawilk/laravel-form-components/resources/js/*.js',
        './storage/framework/views/*.php',
    ],
    safelist: [
        'max-w-none',
        'p-px',
        'text-warning-400',
        'text-[#f2634c]',
        'text-[#f99c26]',
        'text-[#130f32]',
        {
            pattern: /switch-toggle--*/,
        },
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
            pattern: /border-(primary|danger)-(500)/,
            variants: ['sm', 'md', 'lg'],
        },
        {
            pattern: /bg-(primary|danger|gray)-(500)/,
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
            colors: {
                gray: {
                    50: 'rgba(var(--color-gray-50), <alpha-value>)',
                    100: 'rgba(var(--color-gray-100), <alpha-value>)',
                    200: 'rgba(var(--color-gray-200), <alpha-value>)',
                    300: 'rgba(var(--color-gray-300), <alpha-value>)',
                    400: 'rgba(var(--color-gray-400), <alpha-value>)',
                    500: 'rgba(var(--color-gray-500), <alpha-value>)',
                    600: 'rgba(var(--color-gray-600), <alpha-value>)',
                    700: 'rgba(var(--color-gray-700), <alpha-value>)',
                    800: 'rgba(var(--color-gray-800), <alpha-value>)',
                    900: 'rgba(var(--color-gray-900), <alpha-value>)',
                    950: 'rgba(var(--color-gray-950), <alpha-value>)',
                },
                primary: {
                    50: 'rgba(var(--color-primary-50), <alpha-value>)',
                    100: 'rgba(var(--color-primary-100), <alpha-value>)',
                    200: 'rgba(var(--color-primary-200), <alpha-value>)',
                    300: 'rgba(var(--color-primary-300), <alpha-value>)',
                    400: 'rgba(var(--color-primary-400), <alpha-value>)',
                    500: 'rgba(var(--color-primary-500), <alpha-value>)',
                    600: 'rgba(var(--color-primary-600), <alpha-value>)',
                    700: 'rgba(var(--color-primary-700), <alpha-value>)',
                    800: 'rgba(var(--color-primary-800), <alpha-value>)',
                    900: 'rgba(var(--color-primary-900), <alpha-value>)',
                    950: 'rgba(var(--color-primary-950), <alpha-value>)',
                },
                danger: {
                    50: 'rgba(var(--color-danger-50), <alpha-value>)',
                    100: 'rgba(var(--color-danger-100), <alpha-value>)',
                    200: 'rgba(var(--color-danger-200), <alpha-value>)',
                    300: 'rgba(var(--color-danger-300), <alpha-value>)',
                    400: 'rgba(var(--color-danger-400), <alpha-value>)',
                    500: 'rgba(var(--color-danger-500), <alpha-value>)',
                    600: 'rgba(var(--color-danger-600), <alpha-value>)',
                    700: 'rgba(var(--color-danger-700), <alpha-value>)',
                    800: 'rgba(var(--color-danger-800), <alpha-value>)',
                    900: 'rgba(var(--color-danger-900), <alpha-value>)',
                    950: 'rgba(var(--color-danger-950), <alpha-value>)',
                },
                warning: {
                    50: 'rgba(var(--color-warning-50), <alpha-value>)',
                    100: 'rgba(var(--color-warning-100), <alpha-value>)',
                    200: 'rgba(var(--color-warning-200), <alpha-value>)',
                    300: 'rgba(var(--color-warning-300), <alpha-value>)',
                    400: 'rgba(var(--color-warning-400), <alpha-value>)',
                    500: 'rgba(var(--color-warning-500), <alpha-value>)',
                    600: 'rgba(var(--color-warning-600), <alpha-value>)',
                    700: 'rgba(var(--color-warning-700), <alpha-value>)',
                    800: 'rgba(var(--color-warning-800), <alpha-value>)',
                    900: 'rgba(var(--color-warning-900), <alpha-value>)',
                    950: 'rgba(var(--color-warning-950), <alpha-value>)',
                },
                success: {
                    50: 'rgba(var(--color-success-50), <alpha-value>)',
                    100: 'rgba(var(--color-success-100), <alpha-value>)',
                    200: 'rgba(var(--color-success-200), <alpha-value>)',
                    300: 'rgba(var(--color-success-300), <alpha-value>)',
                    400: 'rgba(var(--color-success-400), <alpha-value>)',
                    500: 'rgba(var(--color-success-500), <alpha-value>)',
                    600: 'rgba(var(--color-success-600), <alpha-value>)',
                    700: 'rgba(var(--color-success-700), <alpha-value>)',
                    800: 'rgba(var(--color-success-800), <alpha-value>)',
                    900: 'rgba(var(--color-success-900), <alpha-value>)',
                    950: 'rgba(var(--color-success-950), <alpha-value>)',
                },
                secondary: {
                    50: 'rgba(var(--color-secondary-50), <alpha-value>)',
                    100: 'rgba(var(--color-secondary-100), <alpha-value>)',
                    200: 'rgba(var(--color-secondary-200), <alpha-value>)',
                    300: 'rgba(var(--color-secondary-300), <alpha-value>)',
                    400: 'rgba(var(--color-secondary-400), <alpha-value>)',
                    500: 'rgba(var(--color-secondary-500), <alpha-value>)',
                    600: 'rgba(var(--color-secondary-600), <alpha-value>)',
                    700: 'rgba(var(--color-secondary-700), <alpha-value>)',
                    800: 'rgba(var(--color-secondary-800), <alpha-value>)',
                    900: 'rgba(var(--color-secondary-900), <alpha-value>)',
                    950: 'rgba(var(--color-secondary-950), <alpha-value>)',
                },
                green: {
                    500: '#22c55e',
                },
                yellow: {
                    300: '#fde047',
                    700: '#a16207',
                },
                orange: {
                    500: '#f97316',
                },
                red: {
                    500: '#ef4444',
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
