const mix = require('laravel-mix');
require('laravel-mix-tailwind');

mix.setPublicPath('assets');

mix.js('nova/resources/js/app.js', 'assets/js')
    .less('nova/resources/less/app.less', 'assets/css')
    .less('nova/resources/less/vendor.less', 'assets/css')
    .tailwind('nova/resources/js/tailwind.js')
    .options({ processCssUrls: false })
    .webpackConfig(require('./webpack-custom-config'))
    .sourceMaps(false);

if (process.env.npm_lifecycle_event !== 'hot') {
    mix.version();
}
