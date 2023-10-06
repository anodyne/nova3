/* eslint-disable */
import preset from './vendor/filament/support/tailwind.config.preset';
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
    presets: [preset],
    content: [
        './nova/resources/**/*.{js,ts,blade.php,css}',
        './nova/foundation/View/Components/*.php',
        './nova/src/**/Models/**/*.php',
        './vendor/filament/**/*.blade.php',
        './vendor/livewire-ui/modal/resources/views/*.blade.php',
        './vendor/rawilk/laravel-form-components/src/**/*.php',
        './vendor/rawilk/laravel-form-components/resources/**/*.php',
        './vendor/rawilk/laravel-form-components/resources/js/*.js',
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
            pattern: /bg-(primary|danger|gray|info)-(500)/,
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
            animation: {
                'reverse-spin': 'reverse-spin 1s linear infinite',
            },
            colors: {
                // gray: {
                //     50: 'rgba(var(--gray-50), <alpha-value>)',
                //     100: 'rgba(var(--gray-100), <alpha-value>)',
                //     200: 'rgba(var(--gray-200), <alpha-value>)',
                //     300: 'rgba(var(--gray-300), <alpha-value>)',
                //     400: 'rgba(var(--gray-400), <alpha-value>)',
                //     500: 'rgba(var(--gray-500), <alpha-value>)',
                //     600: 'rgba(var(--gray-600), <alpha-value>)',
                //     700: 'rgba(var(--gray-700), <alpha-value>)',
                //     800: 'rgba(var(--gray-800), <alpha-value>)',
                //     900: 'rgba(var(--gray-900), <alpha-value>)',
                //     950: 'rgba(var(--gray-950), <alpha-value>)',
                // },
                // primary: {
                //     50: 'rgba(var(--primary-50), <alpha-value>)',
                //     100: 'rgba(var(--primary-100), <alpha-value>)',
                //     200: 'rgba(var(--primary-200), <alpha-value>)',
                //     300: 'rgba(var(--primary-300), <alpha-value>)',
                //     400: 'rgba(var(--primary-400), <alpha-value>)',
                //     500: 'rgba(var(--primary-500), <alpha-value>)',
                //     600: 'rgba(var(--primary-600), <alpha-value>)',
                //     700: 'rgba(var(--primary-700), <alpha-value>)',
                //     800: 'rgba(var(--primary-800), <alpha-value>)',
                //     900: 'rgba(var(--primary-900), <alpha-value>)',
                //     950: 'rgba(var(--primary-950), <alpha-value>)',
                // },
                // danger: {
                //     50: 'rgba(var(--danger-50), <alpha-value>)',
                //     100: 'rgba(var(--danger-100), <alpha-value>)',
                //     200: 'rgba(var(--danger-200), <alpha-value>)',
                //     300: 'rgba(var(--danger-300), <alpha-value>)',
                //     400: 'rgba(var(--danger-400), <alpha-value>)',
                //     500: 'rgba(var(--danger-500), <alpha-value>)',
                //     600: 'rgba(var(--danger-600), <alpha-value>)',
                //     700: 'rgba(var(--danger-700), <alpha-value>)',
                //     800: 'rgba(var(--danger-800), <alpha-value>)',
                //     900: 'rgba(var(--danger-900), <alpha-value>)',
                //     950: 'rgba(var(--danger-950), <alpha-value>)',
                // },
                // warning: {
                //     50: 'rgba(var(--warning-50), <alpha-value>)',
                //     100: 'rgba(var(--warning-100), <alpha-value>)',
                //     200: 'rgba(var(--warning-200), <alpha-value>)',
                //     300: 'rgba(var(--warning-300), <alpha-value>)',
                //     400: 'rgba(var(--warning-400), <alpha-value>)',
                //     500: 'rgba(var(--warning-500), <alpha-value>)',
                //     600: 'rgba(var(--warning-600), <alpha-value>)',
                //     700: 'rgba(var(--warning-700), <alpha-value>)',
                //     800: 'rgba(var(--warning-800), <alpha-value>)',
                //     900: 'rgba(var(--warning-900), <alpha-value>)',
                //     950: 'rgba(var(--warning-950), <alpha-value>)',
                // },
                // success: {
                //     50: 'rgba(var(--success-50), <alpha-value>)',
                //     100: 'rgba(var(--success-100), <alpha-value>)',
                //     200: 'rgba(var(--success-200), <alpha-value>)',
                //     300: 'rgba(var(--success-300), <alpha-value>)',
                //     400: 'rgba(var(--success-400), <alpha-value>)',
                //     500: 'rgba(var(--success-500), <alpha-value>)',
                //     600: 'rgba(var(--success-600), <alpha-value>)',
                //     700: 'rgba(var(--success-700), <alpha-value>)',
                //     800: 'rgba(var(--success-800), <alpha-value>)',
                //     900: 'rgba(var(--success-900), <alpha-value>)',
                //     950: 'rgba(var(--success-950), <alpha-value>)',
                // },
                // secondary: {
                //     50: 'rgba(var(--secondary-50), <alpha-value>)',
                //     100: 'rgba(var(--secondary-100), <alpha-value>)',
                //     200: 'rgba(var(--secondary-200), <alpha-value>)',
                //     300: 'rgba(var(--secondary-300), <alpha-value>)',
                //     400: 'rgba(var(--secondary-400), <alpha-value>)',
                //     500: 'rgba(var(--secondary-500), <alpha-value>)',
                //     600: 'rgba(var(--secondary-600), <alpha-value>)',
                //     700: 'rgba(var(--secondary-700), <alpha-value>)',
                //     800: 'rgba(var(--secondary-800), <alpha-value>)',
                //     900: 'rgba(var(--secondary-900), <alpha-value>)',
                //     950: 'rgba(var(--secondary-950), <alpha-value>)',
                // },
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
                sans: ['var(--font-family)', ...defaultTheme.fontFamily.sans],
                // sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                'reverse-spin': {
                    from: {
                        transform: 'rotate(360deg)',
                    },
                },
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
        require('@tailwindcss/container-queries'),
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
