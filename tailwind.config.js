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
        './node_modules/flowbite/**/*.js',
    ],
    safelist: [
        'max-w-none',
        'text-yellow-400',
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
            pattern: /border-(blue|red)-(500)/,
            variants: ['sm', 'md', 'lg'],
        },
        {
            pattern: /bg-(blue|red|gray)-(500)/,
            variants: ['sm', 'md', 'lg'],
        },
    ],
    darkMode: 'class',
    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: '#000',
            white: '#fff',
            // gray: colors.slate,
            // Gray modern
            gray: {
                25: '#fcfcfd',
                50: '#f8fafc',
                100: '#eef2f6',
                200: '#e3e8ef',
                300: '#cdd5df',
                400: '#9aa4b2',
                500: '#697586',
                600: '#4b5565',
                700: '#364152',
                800: '#202939',
                900: '#121926',
            },
            // Gray cool
            // gray: {
            //     25: '#fcfcfd',
            //     50: '#f9f9fb',
            //     100: '#eff1f5',
            //     200: '#dcdfea',
            //     300: '#b9c0d4',
            //     400: '#7d89b0',
            //     500: '#5d6b98',
            //     600: '#4a5578',
            //     700: '#404968',
            //     800: '#30374f',
            //     900: '#111322',
            // },
            blue: {
                25: '#f5faff',
                50: '#eff8ff',
                100: '#d1e9ff',
                200: '#b2ddff',
                300: '#84caff',
                400: '#53b1fd',
                500: '#2e90fa',
                600: '#1570ef',
                700: '#175cd3',
                800: '#1849a9',
                900: '#194185',
            },
            purple: {
                25: '#fcfaff',
                50: '#f9f5ff',
                100: '#f4ebff',
                200: '#e9d7fe',
                300: '#d6bbfb',
                400: '#b692f6',
                500: '#9e77ed',
                600: '#7f56d9',
                700: '#6941c6',
                800: '#53389e',
                900: '#42307d',
            },
            yellow: colors.amber,
            green: colors.emerald,
            red: colors.rose,
            orange: colors.orange,
        },
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
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
                        color: theme('colors.gray.11'),
                        'h1, h2, h3, h4, h5, h6': {
                            color: theme('colors.gray.12'),
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
                            color: theme('colors.gray.11'),
                            borderColor: theme('colors.gray.6'),
                        },
                    },
                },
            }),
        },
    },
    plugins: [
        /* eslint-disable */
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('flowbite/plugin'),
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
