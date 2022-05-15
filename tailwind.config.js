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

module.exports = {
    content: [
        './nova/resources/**/*.{js,ts,blade.php,css}',
        './nova/foundation/View/Components/*.php',
        './nova/vendor/livewire-ui/modal/resources/views/*.blade.php',
        './storage/framework/views/*.php',
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
            gray: colors.slate,
            blue: colors.sky,
            purple: colors.purple,
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
        function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    highlight: (value) => ({ boxShadow: `inset 0 1px 0 0 ${value}` }),
                },
                { values: flattenColorPalette(theme('backgroundColor')), type: 'color' }
            )
        },
        // require('tailwind-safelist-generator')({
        //     patterns: [
        //         'bg-blue-9',
        //         'border-blue-9',
        //         'bg-gray-8',
        //         'bg-gray-9',
        //         'border-gray-8',
        //         'bg-red-9',
        //         'border-red-9',
        //         'max-w-none',
        //         'sm:max-w-lg',
        //         'sm:max-w-xl',
        //         'sm:max-w-2xl',
        //         'sm:max-w-3xl',
        //         'sm:max-w-4xl',
        //         'left-0',
        //         'sm:left-0',
        //         'md:left-0',
        //         'lg:left-0',
        //         'left-auto',
        //         'sm:left-auto',
        //         'md:left-auto',
        //         'lg:left-auto',
        //         'right-0',
        //         'sm:right-0',
        //         'md:right-0',
        //         'lg:right-0',
        //         'right-auto',
        //         'sm:right-auto',
        //         'md:right-auto',
        //         'lg:right-auto',
        //         'origin-top',
        //         'sm:origin-top',
        //         'md:origin-top',
        //         'lg:origin-top',
        //         'origin-top-left',
        //         'sm:origin-top-left',
        //         'md:origin-top-left',
        //         'lg:origin-top-left',
        //         'origin-top-right',
        //         'sm:origin-top-right',
        //         'md:origin-top-right',
        //         'lg:origin-top-right',
        //         'sm:origin-bottom',
        //         'md:origin-bottom',
        //         'lg:origin-bottom',
        //         'origin-bottom-left',
        //         'sm:origin-bottom-left',
        //         'md:origin-bottom-left',
        //         'lg:origin-bottom-left',
        //         'origin-bottom-right',
        //         'sm:origin-bottom-right',
        //         'md:origin-bottom-right',
        //         'lg:origin-bottom-right',
        //     ],
        // }),
        /* eslint-enable */
    ],
};
