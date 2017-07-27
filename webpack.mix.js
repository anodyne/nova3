let mix = require('laravel-mix');

mix.setPublicPath('assets');

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
   .js('nova/resources/assets/js/app.js', 'assets/js')
   .extract(['vue', 'jquery', 'tether', 'axios', 'sortablejs'])
   .sass('nova/resources/assets/sass/app.scss', 'assets/css')
   .sass('nova/resources/assets/sass/responsive.scss', 'assets/css');
