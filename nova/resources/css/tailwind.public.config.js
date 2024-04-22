/* eslint-disable */
import preset from '../../../vendor/filament/support/tailwind.config.preset';
const defaultTheme = require('tailwindcss/defaultTheme');
const { default: flattenColorPalette } = require('tailwindcss/lib/util/flattenColorPalette');
const plugin = require('tailwindcss/plugin');
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
        './vendor/awcodes/scribble/resources/**/*{.blade.php,.svelte}',
        './storage/framework/views/*.php',
        './themes/**/*.blade.php',
    ],
    safelist: [
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
    ],
    darkMode: 'class',
    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            fontFamily: {
                sans: ['var(--font-family)', ...defaultTheme.fontFamily.sans],
                // sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            lineHeight: {
                0: '0',
            },
            spacing: {
                'safe-top': 'env(safe-area-inset-top)',
                'safe-bottom': 'env(safe-area-inset-bottom)',
                'safe-left': 'env(safe-area-inset-left)',
                'safe-right': 'env(safe-area-inset-right)',
            },
            transitionDelay: {
                2000: '2000ms',
                2500: '2500ms',
                3000: '3000ms',
                3500: '3500ms',
                4000: '4000ms',
                4500: '4500ms',
                5000: '5000ms',
            },
            transitionDuration: {
                2000: '2000ms',
                2500: '2500ms',
                3000: '3000ms',
                3500: '3500ms',
                4000: '4000ms',
                4500: '4500ms',
                5000: '5000ms',
            },
        },
    },
    plugins: [
        /* eslint-disable */
        require('@tailwindcss/typography'),
        require('@tailwindcss/container-queries'),
        function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    highlight: (value) => ({ boxShadow: `inset 0 1px 0 0 ${value}` }),
                },
                { values: flattenColorPalette(theme('backgroundColor')), type: 'color' }
            )
        },
        plugin(function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    'animate-duration': (value) => ({ animationDuration: value }),
                },
                { values: theme('transitionDuration') }
            )
        }),
        plugin(function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    'animate-delay': (value) => ({ animationDelay: value }),
                },
                { values: theme('transitionDelay') }
            )
        }),
        plugin(function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    'animate-ease': (value) => ({ animationTimingFunction: value }),
                },
                { values: theme('transitionTimingFunction') }
            )
        }),
        /* eslint-enable */
    ],
};
