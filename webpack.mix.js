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
		'popper.js/dist/umd/popper.js': ['Popper'],
		croppie: ['Croppie', 'window.Croppie'],
		sortablejs: ['Sortable', 'window.Sortable'],
		jquery: ['$', 'jquery', 'jQuery', 'window.jquery']
	})
   .extract([
   		'jquery', 'axios', 'bootstrap', 'croppie',
   		'humanize-number', 'jquery-confirm', 'lodash',
   		'md5', 'pluralize', 'popper.js', 'sortablejs',
   		'vue', 'vue-clickaway', 'vue-js-toggle-button'
   	])
   .js('nova/resources/assets/js/app.js', 'assets/js')
   .sass('nova/resources/assets/sass/app.scss', 'assets/css')
   .sass('nova/resources/assets/sass/responsive.scss', 'assets/css')
   .sass('nova/resources/assets/sass/vendor.scss', 'assets/css');
