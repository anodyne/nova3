module.exports = {
    plugins: [
        /* eslint-disable */
        require('postcss-import'),
        require('tailwindcss'),
        require('postcss-nested'),
        require("autoprefixer"),
        ...(process.env.ENV_BUILD === "prod" ? [require("cssnano")()] : []),
        /* eslint-enable */
    ],
};
