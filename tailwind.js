// const defaultConfig = require('tailwindcss/defaultConfig')();

const colors = {
    transparent: 'transparent',
    black: 'var(--color-black, #22292f)',
    white: 'var(--color-white, #ffffff)',

    'grey-darkest': 'var(--color-grey-darkest, #3d4852)',
    'grey-darker': 'var(--color-grey-darker, #606f7b)',
    'grey-dark': 'var(--color-grey-dark, #8795a1)',
    grey: 'var(--color-grey, #b8c2cc)',
    'grey-light': 'var(--color-grey-light, #dae1e7)',
    'grey-lighter': 'var(--color-grey-lighter, #f1f5f8)',
    'grey-lightest': 'var(--color-grey-lightest, #f8fafc)',

    'red-darkest': 'var(--color-red-darkest, #3b0d0c)',
    'red-darker': 'var(--color-red-darker, #621b18)',
    'red-dark': 'var(--color-red-dark, #cc1f1a)',
    red: 'var(--color-red, #e3342f)',
    'red-light': 'var(--color-red-light, #ef5753)',
    'red-lighter': 'var(--color-red-lighter, #f9acaa)',
    'red-lightest': 'var(--color-red-lightest, #fcebea)',

    'orange-darkest': 'var(--color-orange-darkest, #462a16)',
    'orange-darker': 'var(--color-orange-darker, #613b1f)',
    'orange-dark': 'var(--color-orange-dark, #de751f)',
    orange: 'var(--color-orange, #f6993f)',
    'orange-light': 'var(--color-orange-light, #faad63)',
    'orange-lighter': 'var(--color-orange-lighter, #fcd9b6)',
    'orange-lightest': 'var(--color-orange-lightest, #fff5eb)',

    'yellow-darkest': 'var(--color-yellow-darkest, #453411)',
    'yellow-darker': 'var(--color-yellow-darker, #684f1d)',
    'yellow-dark': 'var(--color-yellow-dark, #f2d024)',
    yellow: 'var(--color-yellow, #ffed4a)',
    'yellow-light': 'var(--color-yellow-light, #fff382)',
    'yellow-lighter': 'var(--color-yellow-lighter, #fff9c2)',
    'yellow-lightest': 'var(--color-yellow-lightest, #fcfbeb)',

    'green-darkest': 'var(--color-green-darkest, #0f2f21)',
    'green-darker': 'var(--color-green-darker, #1a4731)',
    'green-dark': 'var(--color-green-dark, #1f9d55)',
    green: 'var(--color-green, #38c172)',
    'green-light': 'var(--color-green-light, #51d88a)',
    'green-lighter': 'var(--color-green-lighter, #a2f5bf)',
    'green-lightest': 'var(--color-green-lightest, #e3fcec)',

    'teal-darkest': 'var(--color-teal-darkest, #0d3331)',
    'teal-darker': 'var(--color-teal-darker, #20504f)',
    'teal-dark': 'var(--color-teal-dark, #38a89d)',
    teal: 'var(--color-teal, #4dc0b5)',
    'teal-light': 'var(--color-teal-light, #64d5ca)',
    'teal-lighter': 'var(--color-teal-lighter, #a0f0ed)',
    'teal-lightest': 'var(--color-teal-lightest, #e8fffe)',

    'blue-darkest': 'var(--color-blue-darkest, #12283a)',
    'blue-darker': 'var(--color-blue-darker, #1c3d5a)',
    'blue-dark': 'var(--color-blue-dark, #2779bd)',
    blue: 'var(--color-blue, #3490dc)',
    'blue-light': 'var(--color-blue-light, #6cb2eb)',
    'blue-lighter': 'var(--color-blue-lighter, #bcdefa)',
    'blue-lightest': 'var(--color-blue-lightest, #eff8ff)',

    'indigo-darkest': 'var(--color-indigo-darkest, #191e38)',
    'indigo-darker': 'var(--color-indigo-darker, #2f365f)',
    'indigo-dark': 'var(--color-indigo-dark, #5661b3)',
    indigo: 'var(--color-indigo, #6574cd)',
    'indigo-light': 'var(--color-indigo-light, #7886d7)',
    'indigo-lighter': 'var(--color-indigo-lighter, #b2b7ff)',
    'indigo-lightest': 'var(--color-indigo-lightest, #e6e8ff)',

    'purple-darkest': 'var(--color-purple-darkest, #21183c)',
    'purple-darker': 'var(--color-purple-darker, #382b5f)',
    'purple-dark': 'var(--color-purple-dark, #794acf)',
    purple: 'var(--color-purple, #9561e2)',
    'purple-light': 'var(--color-purple-light, #a779e9)',
    'purple-lighter': 'var(--color-purple-lighter, #d6bbfc)',
    'purple-lightest': 'var(--color-purple-lightest, #f3ebff)',

    'pink-darkest': 'var(--color-pink-darkest, #451225)',
    'pink-darker': 'var(--color-pink-darker, #6f213f)',
    'pink-dark': 'var(--color-pink-dark, #eb5286)',
    pink: 'var(--color-pink, #f66d9b)',
    'pink-light': 'var(--color-pink-light, #fa7ea8)',
    'pink-lighter': 'var(--color-pink-lighter, #ffbbca)',
    'pink-lightest': 'var(--color-pink-lightest, #ffebef)',

    'danger-darkest': 'var(--color-danger-darkest, #3b0d0c)',
    'danger-darker': 'var(--color-danger-darker, #621b18)',
    'danger-dark': 'var(--color-danger-dark, #cc1f1a)',
    danger: 'var(--color-danger, #e3342f)',
    'danger-light': 'var(--color-danger-light, #ef5753)',
    'danger-lighter': 'var(--color-danger-lighter, #f9acaa)',
    'danger-lightest': 'var(--color-danger-lightest, #fcebea)',

    'info-darkest': 'var(--color-info-darkest, #0d3331)',
    'info-darker': 'var(--color-info-darker, #20504f)',
    'info-dark': 'var(--color-info-dark, #38a89d)',
    info: 'var(--color-info, #4dc0b5)',
    'info-light': 'var(--color-info-light, #64d5ca)',
    'info-lighter': 'var(--color-info-lighter, #a0f0ed)',
    'info-lightest': 'var(--color-info-lightest, #e8fffe)',

    'primary-darkest': 'var(--color-primary-darkest, #12283a)',
    'primary-darker': 'var(--color-primary-darker, #1c3d5a)',
    'primary-dark': 'var(--color-primary-dark, #2779bd)',
    primary: 'var(--color-primary, #3490dc)',
    'primary-light': 'var(--color-primary-light, #6cb2eb)',
    'primary-lighter': 'var(--color-primary-lighter, #bcdefa)',
    'primary-lightest': 'var(--color-primary-lightest, #eff8ff)',

    'success-darkest': 'var(--color-success-darkest, #0f2f21)',
    'success-darker': 'var(--color-success-darker, #1a4731)',
    'success-dark': 'var(--color-success-dark, #1f9d55)',
    success: 'var(--color-success, #38c172)',
    'success-light': 'var(--color-success-light, #51d88a)',
    'success-lighter': 'var(--color-success-lighter, #a2f5bf)',
    'success-lightest': 'var(--color-success-lightest, #e3fcec)',

    'warning-darkest': 'var(--color-warning-darkest, #ff6f00)',
    'warning-darker': 'var(--color-warning-darker, #ff8f00)',
    'warning-dark': 'var(--color-warning-dark, #ffb300)',
    warning: 'var(--color-warning, #ffc107)',
    'warning-light': 'var(--color-warning-light, #ffca28)',
    'warning-lighter': 'var(--color-warning-lighter, #ffd54f)',
    'warning-lightest': 'var(--color-warning-lightest, #ffecb3)'
};

const spacing = {
    auto: 'auto',
    px: '1px',
    '2px': '2px',
    0: '0rem',
    1: '0.25rem',
    2: '0.5rem',
    3: '0.75rem',
    4: '1rem',
    5: '1.25rem',
    6: '1.5rem',
    7: '1.75rem',
    8: '2rem',
    9: '2.25rem',
    10: '2.5rem',
    11: '2.75rem',
    12: '3rem',
    14: '3.5rem',
    16: '4rem',
    18: '4.5rem',
    20: '5rem',
    24: '6rem',
    28: '7rem',
    32: '8rem',
    40: '10rem',
    48: '12rem',
    56: '14rem',
    64: '16rem',
    72: '18rem',
    80: '20rem',
    96: '24rem',
    128: '32rem'
};

module.exports = {

    colors,

    screens: {
        sm: '576px',
        md: {
            min: '577px',
            max: '768px'
        },
        lg: {
            min: '769px'
        }
    },

    fonts: {
        sans: [
            'system-ui',
            'BlinkMacSystemFont',
            '-apple-system',
            'Segoe UI',
            'Roboto',
            'Oxygen',
            'Ubuntu',
            'Cantarell',
            'Fira Sans',
            'Droid Sans',
            'Helvetica Neue',
            'sans-serif'
        ],
        serif: [
            'Constantia',
            'Lucida Bright',
            'Lucidabright',
            'Lucida Serif',
            'Lucida',
            'DejaVu Serif',
            'Bitstream Vera Serif',
            'Liberation Serif',
            'Georgia',
            'serif'
        ],
        mono: [
            'Menlo',
            'Monaco',
            'Consolas',
            'Liberation Mono',
            'Courier New',
            'monospace'
        ]
    },

    textSizes: {
        '2xs': '.625rem', // 10px
        xs: '.75rem', // 12px
        sm: '.875rem', // 14px
        base: '1rem', // 16px
        lg: '1.125rem', // 18px
        xl: '1.25rem', // 20px
        '2xl': '1.5rem', // 24px
        '3xl': '1.875rem', // 30px
        '4xl': '2.25rem', // 36px
        '5xl': '3rem' // 48px
    },

    fontWeights: {
        light: 300,
        normal: 400,
        medium: 500,
        semibold: 600,
        bold: 700,
        extrabold: 800,
        black: 900
    },

    leading: {
        0: 0,
        none: 1,
        tight: 1.25,
        normal: 1.5,
        loose: 2
    },

    tracking: {
        tight: '-0.05em',
        normal: '0',
        wide: '0.05em'
    },

    textColors: colors,

    backgroundColors: colors,

    backgroundSize: {
        auto: 'auto',
        cover: 'cover',
        contain: 'contain'
    },

    borderWidths: {
        default: '1px',
        0: '0',
        2: '2px',
        4: '4px',
        8: '8px'
    },

    borderColors: global.Object.assign({ default: colors['grey-light'] }, colors),

    borderRadius: {
        none: '0',
        sm: '.1875rem',
        default: '.375rem',
        lg: '.75rem',
        full: '9999px'
    },

    width: {
        ...spacing,
        '1/2': '50%',
        '1/3': '33.33333%',
        '2/3': '66.66667%',
        '1/4': '25%',
        '3/4': '75%',
        '1/5': '20%',
        '2/5': '40%',
        '3/5': '60%',
        '4/5': '80%',
        '1/6': '16.66667%',
        '5/6': '83.33333%',
        full: '100%',
        screen: '100vw'
    },

    height: {
        ...spacing,
        full: '100%',
        screen: '100vh'
    },

    minWidth: {
        0: '0',
        full: '100%'
    },

    minHeight: {
        0: '0',
        full: '100%',
        screen: '100vh'
    },

    maxWidth: {
        xs: '20rem',
        sm: '30rem',
        md: '40rem',
        lg: '50rem',
        xl: '60rem',
        '2xl': '70rem',
        '3xl': '80rem',
        '4xl': '90rem',
        '5xl': '100rem',
        full: '100%'
    },

    maxHeight: {
        full: '100%',
        screen: '100vh'
    },

    padding: spacing,

    margin: spacing,

    negativeMargin: spacing,

    shadows: {
        default: '0 1px 3px rgba(50,50,93,.15), 0 1px 0 rgba(0,0,0,.02)',
        md: '0 4px 6px rgba(50,50,93,.11), 0 1px 3px rgba(0,0,0,.08)',
        lg: '0 18px 35px rgba(50,50,93,.1), 0 8px 15px rgba(0,0,0,.07)',
        inner: 'inset 0 2px 4px 0 rgba(0,0,0,0.06)',
        outline: '0 0 0 3px rgba(52,144,220,0.5)',
        none: 'none'
    },

    zIndex: {
        auto: 'auto',
        0: 0,
        10: 10,
        20: 20,
        30: 30,
        40: 40,
        50: 50,
        100: 100,
        200: 200,
        250: 250,
        500: 500,
        1000: 1000,
        2000: 2000
    },

    opacity: {
        0: '0',
        25: '.25',
        50: '.5',
        75: '.75',
        100: '1'
    },

    svgFill: {
        current: 'currentColor'
    },

    svgStroke: {
        current: 'currentColor'
    },

    modules: {
        appearance: ['responsive'],
        backgroundAttachment: ['responsive'],
        backgroundColors: ['responsive', 'hover', 'group-hover', 'focus', 'focus-within'],
        backgroundPosition: ['responsive'],
        backgroundRepeat: ['responsive'],
        backgroundSize: ['responsive'],
        borderCollapse: [],
        borderColors: ['responsive', 'hover', 'group-hover', 'focus', 'focus-within'],
        borderRadius: ['responsive'],
        borderStyle: ['responsive'],
        borderWidths: ['responsive'],
        cursor: ['responsive'],
        display: ['responsive'],
        flexbox: ['responsive'],
        float: ['responsive'],
        fonts: ['responsive'],
        fontWeights: ['responsive', 'hover', 'focus'],
        height: ['responsive'],
        leading: ['responsive'],
        lists: ['responsive'],
        margin: ['responsive'],
        maxHeight: ['responsive'],
        maxWidth: ['responsive'],
        minHeight: ['responsive'],
        minWidth: ['responsive'],
        negativeMargin: ['responsive'],
        objectFit: ['responsive'],
        objectPosition: ['responsive'],
        opacity: ['responsive'],
        outline: ['focus'],
        overflow: ['responsive'],
        padding: ['responsive'],
        pointerEvents: ['responsive'],
        position: ['responsive'],
        resize: ['responsive'],
        shadows: ['responsive', 'hover', 'group-hover', 'focus', 'focus-within'],
        svgFill: [],
        svgStroke: [],
        tableLayout: ['responsive'],
        textAlign: ['responsive'],
        textColors: ['responsive', 'hover', 'group-hover', 'focus', 'focus-within'],
        textSizes: ['responsive'],
        textStyle: ['responsive', 'hover', 'group-hover', 'focus', 'focus-within'],
        tracking: ['responsive'],
        userSelect: ['responsive'],
        verticalAlign: ['responsive'],
        visibility: ['responsive'],
        whitespace: ['responsive'],
        width: ['responsive'],
        zIndex: ['responsive']
    },

    plugins: [
        require('tailwindcss/plugins/container')({
            center: true,
            padding: '1rem'
        })
    ],

    options: {
        prefix: '',
        important: false,
        separator: ':'
    }

};
