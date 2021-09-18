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

module.exports = {
    mode: 'jit',

    purge: [
        './nova/resources/**/*.{js,ts,blade.php,css}',
        './nova/foundation/View/Components/*.php',
        './safelist.txt',
    ],

    darkMode: false, // or 'media' or 'class'

    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: '#000',
            white: '#fff',

            ...createColorScale('blue'),
            ...createColorScale('gray'),
            ...createColorScale('green'),
            ...createColorScale('orange'),
            ...createColorScale('purple'),
            ...createColorScale('red'),
            ...createColorScale('yellow'),
        },
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            boxShadow: (theme) => ({
                nav: `inset 1px 0 ${theme('colors.gray.6')}`,
            }),
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            lineHeight: {
                0: 0,
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
        },
    },

    variants: {},

    plugins: [
        /* eslint-disable */
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
        require('tailwindcss-interaction-variants'),
        require('tailwind-safelist-generator')({
            patterns: [
                'bg-blue-9',
                'border-blue-9',
                'bg-gray-8',
                'border-gray-8',
                'bg-red-9',
                'border-red-9',
            ],
        }),
        /* eslint-enable */
    ],
};
