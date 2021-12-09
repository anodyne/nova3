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
        './nova/vendor/livewire-ui/modal/resources/views/*.blade.php',
        './storage/framework/views/*.php',
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
                'bg-gray-9',
                'border-gray-8',
                'bg-red-9',
                'border-red-9',
                'max-w-none',
                'sm:max-w-lg',
                'sm:max-w-xl',
                'sm:max-w-2xl',
                'sm:max-w-3xl',
                'sm:max-w-4xl',
                'left-0',
                '{screens}:left-0',
                'left-auto',
                '{screens}:left-auto',
                'right-0',
                '{screens}:right-0',
                'right-auto',
                '{screens}:right-auto',
                'origin-top',
                '{screens}:origin-top',
                'origin-top-left',
                '{screens}:origin-top-left',
                'origin-top-right',
                '{screens}:origin-top-right',
                'origin-bottom',
                '{screens}:origin-bottom',
                'origin-bottom-left',
                '{screens}:origin-bottom-left',
                'origin-bottom-right',
                '{screens}:origin-bottom-right',
            ],
        }),
        /* eslint-enable */
    ],
};
