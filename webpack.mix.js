let mix = require('laravel-mix');

mix.setPublicPath('resources');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.autoload({
		tether: ['Tether', 'window.Tether']
	})
   .js('nova/resources/assets/js/app.js', 'resources/js')
   .extract(['vue', 'jquery', 'tether', 'axios'])
   .sass('nova/resources/assets/sass/app.scss', 'resources/css');
