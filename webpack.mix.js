const mix = require('laravel-mix');
require('laravel-mix-tailwind');

mix.setPublicPath('dist');

mix.js('nova/resources/js/app.js', 'dist/js')
    .less('nova/resources/less/app.less', 'dist/css')
    .less('nova/resources/less/vendor.less', 'dist/css')
    .tailwind()
    .webpackConfig(require('./webpack-custom-config'));
