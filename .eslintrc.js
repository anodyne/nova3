module.exports = {
    'extends': [
        'airbnb-base',
        'plugin:vue/recommended'
    ],

    'parserOptions': {
        'ecmaVersion': 2018
    },

    'env': {
        'browser': true,
        'node': true,
        'es6': true,
        'jest': true
    },

    'globals': {
        'Nova': true
    },

    'settings': {
        'import/resolver': {
            'webpack': {
                'config': 'webpack-custom-config.js',
            }
        }
    },

    'rules': {
        'arrow-body-style': ['error', 'always'],
        'class-methods-use-this': 'off',
        'comma-dangle': ['error', 'never'],
        'func-names': ['error', 'never'],
        'indent': ['error', 4, {
            'SwitchCase': 1
        }],
        'max-len': 'off',
        'no-plusplus': ['error', {
            'allowForLoopAfterthoughts': true
        }],
        'quotes': ['error', 'single', {
            allowTemplateLiterals: true,
        }],
        'space-before-function-paren': ['error', 'always'],

        'vue/component-name-in-template-casing': ['error',
            'kebab-case', {
                'ignores': []
            }
        ],
        'vue/html-closing-bracket-newline': ['error', {
            'singleline': 'never',
            'multiline': 'always'
        }],
        'vue/html-indent': ['error', 4],
        'vue/html-self-closing': ['error', {
            'html': {
                'void': 'never',
                'normal': 'never',
                'component': 'never'
            },
            'svg': 'always',
            'math': 'always'
        }],
        'vue/max-attributes-per-line': ['error', {
            'singleline': 2,
            'multiline': {
                'max': 1,
                'allowFirstLine': false
            }
        }],
        'vue/multiline-html-element-content-newline': 'off',
        'vue/no-unused-components': 'off',
        'vue/no-v-html': 'warning',
        'vue/singleline-html-element-content-newline': 'off',
    }
};
