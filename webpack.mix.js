const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-tailwind');

mix.setPublicPath('dist');

mix.js('nova/resources/js/app.js', 'dist/js')
    .js('nova/resources/js/app-server.js', 'dist/js')
    .less('nova/resources/less/app.less', 'dist/css')
    .less('nova/resources/less/vendor.less', 'dist/css')
    .tailwind('./tailwind.config.js')
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
        }
    });
