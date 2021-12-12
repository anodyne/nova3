module.exports = {
    plugins: [
        /* eslint-disable */
        require('postcss-import'),
        require('tailwindcss/nesting'),
        require('tailwindcss'),
        require("autoprefixer"),
        ...(process.env.ENV_BUILD === "prod" ? [require("cssnano")()] : []),
        /* eslint-enable */
    ],
};
