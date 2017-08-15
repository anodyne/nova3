let mix = require('laravel-mix');

mix.setPublicPath('assets');

mix.autoload({
		'popper.js/dist/umd/popper.js': ['Popper'],
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
