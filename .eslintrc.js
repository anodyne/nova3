module.exports = {
    extends: [
        'airbnb-base',
    ],
    parserOptions: {
        ecmaVersion: 2020,
    },
    env: {
        browser: true,
        node: true,
        es6: true,
    },
    globals: {
        Nova: true,
    },
    rules: {
        indent: ['error', 4, { SwitchCase: 1 }],
        'func-names': ['error', 'as-needed'],
        'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-return-assign': ['error', 'except-parens'],
    },
};
