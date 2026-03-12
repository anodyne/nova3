/* eslint-disable */
const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');

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
        './nova/resources/**/*.{js,ts,blade.php,css,svg}',
        './nova/foundation/View/Components/*.php',
        './nova/src/**/Enums/*.php',
        './nova/src/**/Models/**/*.php',
        './vendor/filament/**/*.blade.php',
        './vendor/livewire-ui/modal/resources/views/*.blade.php',
        './vendor/rawilk/laravel-form-components/src/**/*.php',
        './vendor/rawilk/laravel-form-components/resources/**/*.php',
        './vendor/rawilk/laravel-form-components/resources/js/*.js',
        './vendor/livewire/flux-pro/stubs/**/*.blade.php',
        './vendor/livewire/flux/stubs/**/*.blade.php',
        './vendor/ralphjsmit/laravel-filament-activitylog/resources/**/*.blade.php',
        './storage/framework/views/*.php',
        './vendor/wire-elements/pro/config/wire-elements-pro.php',
        './vendor/wire-elements/pro/**/*.blade.php',
    ],
    safelist: [
        'max-w-none',
        'p-px',
        'text-warning-400',
        'text-[#f2634c]',
        'text-[#f99c26]',
        'text-[#130f32]',
        'bg-sky-500',
        'bg-sky-700',
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
        {
            pattern: /bg-(red|orange|amber|yellow|lime|emerald|green|sky|teal|cyan|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900|950)/,
            variants: ['sm', 'md', 'lg'],
        },
    ],
    darkMode: 'selector',
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
                zinc: {
                    50: 'rgba(var(--gray-50), <alpha-value>)',
                    100: 'rgba(var(--gray-100), <alpha-value>)',
                    200: 'rgba(var(--gray-200), <alpha-value>)',
                    300: 'rgba(var(--gray-300), <alpha-value>)',
                    400: 'rgba(var(--gray-400), <alpha-value>)',
                    500: 'rgba(var(--gray-500), <alpha-value>)',
                    600: 'rgba(var(--gray-600), <alpha-value>)',
                    700: 'rgba(var(--gray-700), <alpha-value>)',
                    800: 'rgba(var(--gray-800), <alpha-value>)',
                    900: 'rgba(var(--gray-900), <alpha-value>)',
                    950: 'rgba(var(--gray-950), <alpha-value>)',
                },
                discord: '#5865f2',
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
            spacing: {
                'safe-top': 'env(safe-area-inset-top)',
                'safe-bottom': 'env(safe-area-inset-bottom)',
                'safe-left': 'env(safe-area-inset-left)',
                'safe-right': 'env(safe-area-inset-right)',
            },
        },
    },
    plugins: [
        /* eslint-disable */
        require('@tailwindcss/typography'),
        require('@tailwindcss/container-queries'),
        // function ({ matchUtilities, theme }) {
        //     matchUtilities(
        //         {
        //             highlight: (value) => ({ boxShadow: `inset 0 1px 0 0 ${value}` }),
        //         },
        //         { values: flattenColorPalette(theme('backgroundColor')), type: 'color' }
        //     )
        // },
        /* eslint-enable */
    ],
};
