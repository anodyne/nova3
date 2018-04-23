let mix = require('laravel-mix')
let tailwindcss = require('tailwindcss')

mix.setPublicPath('assets')

mix.autoload({
		jquery: ['$', 'jquery', 'jQuery', 'window.jquery'],
		'moment': ['moment', 'window.moment'],
		'webui-popover': ['webuiPopover', 'window.webuiPopover']
	})
	.extract([
		'jquery', 'axios', 'croppie', 'humanize-number',
		'jquery-confirm', 'lodash', 'md5', 'moment', 'pluralize',
		'sortablejs', 'vue', 'vue-clickaway', 'vue-js-toggle-button',
		'webui-popover', 'sweetalert2', 'lightbox2'
	])
   .js('nova/resources/assets/js/app.js', 'assets/js')
   .less('nova/resources/assets/less/app.less', 'assets/css')
   .less('nova/resources/assets/less/vendor.less', 'assets/css')
   .options({
   		postCss: [
			tailwindcss('./nova/resources/assets/js/tailwind.js'),
		],
		processCssUrls: false
	})
