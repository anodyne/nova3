// const defaultConfig = require('tailwindcss/defaultConfig')();

const colors = {
    transparent: 'transparent',
    black: 'var(--color-black, hsl(0, 0%, 0%))',
    white: 'var(--color-white, hsl(0, 0%, 100%))',

    'grey-50': 'var(--color-grey-50, hsl(210, 36%, 96%))', // lightest
    'grey-100': 'var(--color-grey-100, hsl(212, 33%, 89%))', // lighter
    'grey-200': 'var(--color-grey-200, hsl(210, 31%, 80%))', // light
    'grey-300': 'var(--color-grey-300, hsl(211, 27%, 70%))', // base
    'grey-400': 'var(--color-grey-400, hsl(209, 23%, 60%))', // dark
    'grey-500': 'var(--color-grey-500, hsl(210, 22%, 49%))',
    'grey-600': 'var(--color-grey-600, hsl(209, 28%, 39%))', // darker
    'grey-700': 'var(--color-grey-700, hsl(209, 34%, 30%))',
    'grey-800': 'var(--color-grey-800, hsl(211, 39%, 23%))', // darkest
    'grey-900': 'var(--color-grey-900, hsl(209, 61%, 16%))',

    'red-50': 'var(--color-red-50, hsl(360, 100%, 97%))',
    'red-100': 'var(--color-red-100, hsl(360, 82%, 89%))',
    'red-200': 'var(--color-red-200, hsl(360, 77%, 78%))',
    'red-300': 'var(--color-red-300, hsl(360, 71%, 66%))',
    'red-400': 'var(--color-red-400, hsl(360, 64%, 55%))',
    'red-500': 'var(--color-red-500, hsl(360, 67%, 44%))',
    'red-600': 'var(--color-red-600, hsl(360, 72%, 38%))',
    'red-700': 'var(--color-red-700, hsl(360, 79%, 32%))',
    'red-800': 'var(--color-red-800, hsl(360, 85%, 25%))',
    'red-900': 'var(--color-red-900, hsl(360, 92%, 20%))',

    'orange-50': 'var(--color-orange-50, hsl(22, 100%, 95%))',
    'orange-100': 'var(--color-orange-100, hsl(22, 100%, 86%))',
    'orange-200': 'var(--color-orange-200, hsl(22, 92%, 76%))',
    'orange-300': 'var(--color-orange-300, hsl(21, 83%, 64%))',
    'orange-400': 'var(--color-orange-400, hsl(22, 78%, 55%))',
    'orange-500': 'var(--color-orange-500, hsl(22, 71%, 45%))',
    'orange-600': 'var(--color-orange-600, hsl(22, 74%, 38%))',
    'orange-700': 'var(--color-orange-700, hsl(22, 79%, 31%))',
    'orange-800': 'var(--color-orange-800, hsl(22, 80%, 26%))',
    'orange-900': 'var(--color-orange-900, hsl(22, 83%, 19%))',

    'yellow-50': 'var(--color-yellow-50, hsl(45, 100%, 96%))',
    'yellow-100': 'var(--color-yellow-100, hsl(45, 90%, 88%))',
    'yellow-200': 'var(--color-yellow-200, hsl(45, 86%, 81%))',
    'yellow-300': 'var(--color-yellow-300, hsl(43, 90%, 76%))',
    'yellow-400': 'var(--color-yellow-400, hsl(43, 89%, 70%))',
    'yellow-500': 'var(--color-yellow-500, hsl(42, 78%, 60%))',
    'yellow-600': 'var(--color-yellow-600, hsl(42, 63%, 48%))',
    'yellow-700': 'var(--color-yellow-700, hsl(43, 72%, 37%))',
    'yellow-800': 'var(--color-yellow-800, hsl(43, 77%, 27%))',
    'yellow-900': 'var(--color-yellow-900, hsl(43, 86%, 17%))',

    'lime-green-50': 'var(--color-lime-green-50, hsl(83, 88%, 94%))',
    'lime-green-100': 'var(--color-lime-green-100, hsl(84, 77%, 86%))',
    'lime-green-200': 'var(--color-lime-green-200, hsl(83, 68%, 74%))',
    'lime-green-300': 'var(--color-lime-green-300, hsl(83, 63%, 61%))',
    'lime-green-400': 'var(--color-lime-green-400, hsl(83, 55%, 52%))',
    'lime-green-500': 'var(--color-lime-green-500, hsl(83, 64%, 42%))',
    'lime-green-600': 'var(--color-lime-green-600, hsl(83, 70%, 34%))',
    'lime-green-700': 'var(--color-lime-green-700, hsl(83, 74%, 27%))',
    'lime-green-800': 'var(--color-lime-green-800, hsl(81, 78%, 21%))',
    'lime-green-900': 'var(--color-lime-green-900, hsl(81, 86%, 14%))',

    'green-50': 'var(--color-green-50, hsl(125, 65%, 93%))',
    'green-100': 'var(--color-green-100, hsl(126, 49%, 84%))',
    'green-200': 'var(--color-green-200, hsl(122, 42%, 75%))',
    'green-300': 'var(--color-green-300, hsl(123, 38%, 63%))',
    'green-400': 'var(--color-green-400, hsl(123, 35%, 51%))',
    'green-500': 'var(--color-green-500, hsl(122, 39%, 41%))',
    'green-600': 'var(--color-green-600, hsl(122, 47%, 35%))',
    'green-700': 'var(--color-green-700, hsl(125, 56%, 29%))',
    'green-800': 'var(--color-green-800, hsl(125, 73%, 20%))',
    'green-900': 'var(--color-green-900, hsl(125, 86%, 14%))',

    'cyan-50': 'var(--color-cyan-50, hsl(186, 100%, 94%))',
    'cyan-100': 'var(--color-cyan-100, hsl(185, 94%, 87%))',
    'cyan-200': 'var(--color-cyan-200, hsl(184, 80%, 74%))',
    'cyan-300': 'var(--color-cyan-300, hsl(184, 65%, 59%))',
    'cyan-400': 'var(--color-cyan-400, hsl(185, 57%, 50%))',
    'cyan-500': 'var(--color-cyan-500, hsl(185, 62%, 45%))',
    'cyan-600': 'var(--color-cyan-600, hsl(184, 77%, 34%))',
    'cyan-700': 'var(--color-cyan-700, hsl(185, 81%, 29%))',
    'cyan-800': 'var(--color-cyan-800, hsl(185, 84%, 25%))',
    'cyan-900': 'var(--color-cyan-900, hsl(184, 91%, 17%))',

    'light-blue-50': 'var(--color-light-blue-50, hsl(201, 100%, 96%))',
    'light-blue-100': 'var(--color-light-blue-100, hsl(200, 88%, 90%))',
    'light-blue-200': 'var(--color-light-blue-200, hsl(200, 71%, 80%))',
    'light-blue-300': 'var(--color-light-blue-300, hsl(200, 66%, 69%))',
    'light-blue-400': 'var(--color-light-blue-400, hsl(200, 60%, 58%))',
    'light-blue-500': 'var(--color-light-blue-500, hsl(200, 54%, 49%))',
    'light-blue-600': 'var(--color-light-blue-600, hsl(200, 59%, 43%))',
    'light-blue-700': 'var(--color-light-blue-700, hsl(200, 68%, 35%))',
    'light-blue-800': 'var(--color-light-blue-800, hsl(200, 72%, 31%))',
    'light-blue-900': 'var(--color-light-blue-900, hsl(200, 82%, 24%))',

    'blue-50': 'var(--color-blue-50, hsl(205, 79%, 92%))',
    'blue-100': 'var(--color-blue-100, hsl(205, 97%, 85%))',
    'blue-200': 'var(--color-blue-200, hsl(205, 84%, 74%))',
    'blue-300': 'var(--color-blue-300, hsl(205, 74%, 65%))',
    'blue-400': 'var(--color-blue-400, hsl(205, 65%, 55%))',
    'blue-500': 'var(--color-blue-500, hsl(205, 67%, 45%))',
    'blue-600': 'var(--color-blue-600, hsl(205, 76%, 39%))',
    'blue-700': 'var(--color-blue-700, hsl(205, 82%, 33%))',
    'blue-800': 'var(--color-blue-800, hsl(205, 87%, 29%))',
    'blue-900': 'var(--color-blue-900, hsl(205, 100%, 21%))',

    'indigo-50': 'var(--color-indigo-50, hsl(221, 68%, 93%))',
    'indigo-100': 'var(--color-indigo-100, hsl(221, 78%, 86%))',
    'indigo-200': 'var(--color-indigo-200, hsl(224, 67%, 76%))',
    'indigo-300': 'var(--color-indigo-300, hsl(225, 57%, 67%))',
    'indigo-400': 'var(--color-indigo-400, hsl(227, 50%, 59%))',
    'indigo-500': 'var(--color-indigo-500, hsl(227, 42%, 51%))',
    'indigo-600': 'var(--color-indigo-600, hsl(228, 45%, 45%))',
    'indigo-700': 'var(--color-indigo-700, hsl(230, 49%, 41%))',
    'indigo-800': 'var(--color-indigo-800, hsl(232, 51%, 36%))',
    'indigo-900': 'var(--color-indigo-900, hsl(234, 62%, 26%))',

    'purple-50': 'var(--color-purple-50, hsl(262, 61%, 93%))',
    'purple-100': 'var(--color-purple-100, hsl(261, 68%, 84%))',
    'purple-200': 'var(--color-purple-200, hsl(261, 54%, 68%))',
    'purple-300': 'var(--color-purple-300, hsl(261, 47%, 58%))',
    'purple-400': 'var(--color-purple-400, hsl(262, 45%, 51%))',
    'purple-500': 'var(--color-purple-500, hsl(262, 48%, 46%))',
    'purple-600': 'var(--color-purple-600, hsl(262, 60%, 38%))',
    'purple-700': 'var(--color-purple-700, hsl(262, 69%, 31%))',
    'purple-800': 'var(--color-purple-800, hsl(262, 72%, 25%))',
    'purple-900': 'var(--color-purple-900, hsl(263, 85%, 18%))',

    'pink-50': 'var(--color-pink-50, hsl(329, 100%, 94%))',
    'pink-100': 'var(--color-pink-100, hsl(330, 87%, 85%))',
    'pink-200': 'var(--color-pink-200, hsl(330, 77%, 76%))',
    'pink-300': 'var(--color-pink-300, hsl(330, 72%, 65%))',
    'pink-400': 'var(--color-pink-400, hsl(330, 66%, 57%))',
    'pink-500': 'var(--color-pink-500, hsl(330, 63%, 47%))',
    'pink-600': 'var(--color-pink-600, hsl(330, 68%, 40%))',
    'pink-700': 'var(--color-pink-700, hsl(330, 70%, 36%))',
    'pink-800': 'var(--color-pink-800, hsl(330, 74%, 27%))',
    'pink-900': 'var(--color-pink-900, hsl(330, 79%, 20%))',

    'danger-50': 'var(--color-danger-50, hsl(360, 100%, 97%))',
    'danger-100': 'var(--color-danger-100, hsl(360, 82%, 89%))',
    'danger-200': 'var(--color-danger-200, hsl(360, 77%, 78%))',
    'danger-300': 'var(--color-danger-300, hsl(21, 71%, 66%))',
    'danger-400': 'var(--color-danger-400, hsl(360, 64%, 55%))',
    'danger-500': 'var(--color-danger-500, hsl(360, 67%, 44%))',
    'danger-600': 'var(--color-danger-600, hsl(360, 72%, 38%))',
    'danger-700': 'var(--color-danger-700, hsl(360, 79%, 32%))',
    'danger-800': 'var(--color-danger-800, hsl(360, 85%, 25%))',
    'danger-900': 'var(--color-danger-900, hsl(360, 92%, 20%))',

    'info-50': 'var(--color-info-50, hsl(186, 100%, 94%))',
    'info-100': 'var(--color-info-100, hsl(185, 94%, 87%))',
    'info-200': 'var(--color-info-200, hsl(184, 80%, 74%))',
    'info-300': 'var(--color-info-300, hsl(184, 65%, 59%))',
    'info-400': 'var(--color-info-400, hsl(185, 57%, 50%))',
    'info-500': 'var(--color-info-500, hsl(185, 62%, 45%))',
    'info-600': 'var(--color-info-600, hsl(184, 77%, 34%))',
    'info-700': 'var(--color-info-700, hsl(185, 81%, 29%))',
    'info-800': 'var(--color-info-800, hsl(185, 84%, 25%))',
    'info-900': 'var(--color-info-900, hsl(184, 91%, 17%))',

    'primary-50': 'var(--color-primary-50, hsl(205, 79%, 92%))',
    'primary-100': 'var(--color-primary-100, hsl(205, 97%, 85%))',
    'primary-200': 'var(--color-primary-200, hsl(205, 84%, 74%))',
    'primary-300': 'var(--color-primary-300, hsl(205, 74%, 65%))',
    'primary-400': 'var(--color-primary-400, hsl(205, 65%, 55%))',
    'primary-500': 'var(--color-primary-500, hsl(205, 67%, 45%))',
    'primary-600': 'var(--color-primary-600, hsl(205, 76%, 39%))',
    'primary-700': 'var(--color-primary-700, hsl(205, 82%, 33%))',
    'primary-800': 'var(--color-primary-800, hsl(205, 87%, 29%))',
    'primary-900': 'var(--color-primary-900, hsl(205, 100%, 21%))',

    'success-50': 'var(--color-success-50, hsl(125, 65%, 93%))',
    'success-100': 'var(--color-success-100, hsl(126, 49%, 84%))',
    'success-200': 'var(--color-success-200, hsl(122, 42%, 75%))',
    'success-300': 'var(--color-success-300, hsl(123, 38%, 63%))',
    'success-400': 'var(--color-success-400, hsl(123, 35%, 51%))',
    'success-500': 'var(--color-success-500, hsl(122, 39%, 41%))',
    'success-600': 'var(--color-success-600, hsl(122, 47%, 35%))',
    'success-700': 'var(--color-success-700, hsl(125, 56%, 29%))',
    'success-800': 'var(--color-success-800, hsl(125, 73%, 20%))',
    'success-900': 'var(--color-success-900, hsl(125, 86%, 14%))',

    'warning-50': 'var(--color-warning-50, hsl(45, 100%, 96%))',
    'warning-100': 'var(--color-warning-100, hsl(45, 90%, 88%))',
    'warning-200': 'var(--color-warning-200, hsl(45, 86%, 81%))',
    'warning-300': 'var(--color-warning-300, hsl(43, 90%, 76%))',
    'warning-400': 'var(--color-warning-400, hsl(43, 89%, 70%))',
    'warning-500': 'var(--color-warning-500, hsl(42, 78%, 60%))',
    'warning-600': 'var(--color-warning-600, hsl(42, 63%, 48%))',
    'warning-700': 'var(--color-warning-700, hsl(43, 72%, 37%))',
    'warning-800': 'var(--color-warning-800, hsl(43, 77%, 27%))',
    'warning-900': 'var(--color-warning-900, hsl(43, 86%, 17%))'
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
        md: '768px',
        lg: '992px'
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

    borderColors: global.Object.assign({ default: colors['grey-100'] }, colors),

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
