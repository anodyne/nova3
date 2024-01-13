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
