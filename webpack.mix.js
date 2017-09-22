let mix = require('laravel-mix');

mix.setPublicPath('assets');

mix.autoload({
		'popper.js/dist/umd/popper.js': ['Popper'],
		jquery: ['$', 'jquery', 'jQuery', 'window.jquery'],
		'moment': ['moment', 'window.moment'],
		'webui-popover': ['webuiPopover', 'window.webuiPopover']
	})
	.extract([
		'jquery', 'axios', 'bootstrap', 'croppie', 'humanize-number',
		'jquery-confirm', 'lodash', 'md5', 'moment', 'pluralize', 'popper.js',
		'sortablejs', 'vue', 'vue-clickaway', 'vue-js-toggle-button',
		'webui-popover', 'sweetalert2'
	])
   .js('nova/resources/assets/js/app.js', 'assets/js')
   .sass('nova/resources/assets/sass/app.scss', 'assets/css')
   .sass('nova/resources/assets/sass/responsive.scss', 'assets/css')
   .sass('nova/resources/assets/sass/vendor.scss', 'assets/css')
   .sass('nova/resources/assets/sass/setup.scss', 'assets/css')
   .sass('nova/resources/assets/sass/setup.responsive.scss', 'assets/css')
   .options({
		processCssUrls: false
	});
