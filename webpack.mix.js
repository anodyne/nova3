const { mix } = require('laravel-mix');

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

mix.setPublicPath('nova/dist')
	.scripts([
		'nova/resources/js/functions.js',
		'nova/resources/js/vue/filters.js',
		'nova/resources/js/vue/components.js',
		'node_modules/sweetalert2/dist/sweetalert2.min.js',
		'node_modules/underscore/underscore-min.js'
	], 'nova/dist/js/all.js')
	.sass('nova/resources/scss/base.style.scss', 'css')
	.sass('nova/resources/scss/base.icons.scss', 'css')
	.sass('nova/resources/scss/base.responsive.scss', 'css')
	.sass('nova/resources/scss/auth.style.scss', 'css')
	.styles([
		'node_modules/sweetalert2/dist/sweetalert2.min.css',
		'nova/resources/css/typeahead.css'
	], 'nova/dist/css/all.css')
