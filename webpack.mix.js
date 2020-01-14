const mix = require('laravel-mix');
const path = require('path');

mix.setPublicPath('dist');

mix.js('nova/resources/js/app.js', 'dist/js')
    .js('nova/resources/js/app-server.js', 'dist/js')

    .postCss('nova/resources/css/app.css', 'dist/css')
    .postCss('nova/resources/css/vendor.css', 'dist/css')

    .options({
        postCss: [
            /* eslint-disable */
            require('postcss-import'),
            require('tailwindcss'),
            require('postcss-nested')
            /* eslint-enable */
        ],
        processCssUrls: false
    })

    .babelConfig({
        plugins: ['@babel/plugin-syntax-dynamic-import']
    })

    .webpackConfig({
        output: {
            chunkFilename: 'js/[name].[contenthash].js',
            publicPath: '/dist/'
        },
        resolve: {
            alias: {
                '@': path.resolve(__dirname, './nova/resources/js/'),
                '@node_modules': path.resolve(__dirname, './node_modules/')
            },
            symlinks: false
        },
        node: {
            fs: 'empty'
        }
    });
