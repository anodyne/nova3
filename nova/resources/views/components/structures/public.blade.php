<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="{{ $_settings->get('metadata_author') }}">
		<meta name="description" content="{{ $mdDescription or $_page->metadata->get('description') }}">
		<meta name="keywords" content="{{ $_settings->get('metadata_keywords') }}">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ $pageTitle or $_page->present()->title }} &bull; {{ $_content->get('sim.name') }}</title>

		<meta property="og:type" content="{{ $mdType or 'website' }}">
		<meta property="og:url" content="{{ request()->fullUrl() }}">
		<meta property="og:title" content="{{ $_content->get('sim.name') }}: {{ $mdTitle or $_page->name }}">
		<meta property="og:description" content="{{ $mdDescription or $_page->description }}">
		<meta property="og:image" content="">
		<meta property="twitter:card" content="summary">
		<meta property="twitter:site" content="{{ $_settings->get('metadata_twitter') }}">
		<meta property="twitter:title" content="{{ $_content->get('sim.name') }}: {{ $mdTitle or $_page->name }}">
		<meta property="twitter:description" content="{{ $mdDescription or $_page->description }}">
		<meta property="twitter:image" content="">

		@if (app('files')->exists(theme_path('design/css/bootstrap.css', false)))
			{!! HTML::style(theme_path('design/css/bootstrap.css')) !!}
		@else
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		@endif
		{!! HTML::style('nova/resources/css/summernote.css') !!}
		{!! HTML::style('nova/resources/css/sweetalert.css') !!}
		{!! partial('fonts-include') !!}
		{!! partial('icons-include') !!}

		@if (app('files')->exists(theme_path('design/css/icons.css', false)))
			{!! HTML::style(theme_path('design/css/icons.css')) !!}
		@else
			@if (app('files')->exists(theme_path('design/css/custom.icons.css', false)))
				{!! HTML::style(theme_path('design/css/custom.icons.css')) !!}
			@endif

			{!! HTML::style('nova/resources/views/design/css/base.icons.css') !!}
		@endif

		@if (app('files')->exists(theme_path('design/css/style.css', false)))
			{!! HTML::style(theme_path('design/css/style.css')) !!}
		@else
			{!! HTML::style('nova/resources/views/design/css/base.style.css') !!}

			@if (app('files')->exists(theme_path('design/css/custom.css', false)))
				{!! HTML::style(theme_path('design/css/custom.css')) !!}
			@endif
		@endif

		@if (user() and user()->preference('theme_variant'))
			{!! HTML::style(theme_path("design/css/variants/{user()->preference('theme_variant')}.css")) !!}
		@endif
		@if ( ! user() and ! empty($_settings->get('theme_variant')))
			{!! HTML::style(theme_path("design/css/variants/{$_settings->get('theme_variant')}.css")) !!}
		@endif

		@if (app('files')->exists(theme_path('design/css/responsive.css', false)))
			{!! HTML::style(theme_path('design/css/responsive.css')) !!}
		@else
			@if (app('files')->exists(theme_path('design/css/custom.responsive.css', false)))
				{!! HTML::style(theme_path('design/css/custom.responsive.css')) !!}
			@endif

			{!! HTML::style('nova/resources/views/design/css/base.responsive.css') !!}
		@endif

		{!! $styles or false !!}
	</head>
	<body>
		{!! $template or false !!}

		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>
		{!! HTML::script('nova/resources/js/underscore-min.js') !!}
		{!! HTML::script('nova/resources/js/summernote.min.js') !!}
		{!! HTML::script('nova/resources/js/functions.js') !!}
		{!! HTML::script('nova/resources/js/sweetalert.min.js') !!}
		{!! HTML::script('nova/resources/js/vue/components.js') !!}
		{!! HTML::script('nova/resources/js/vue/filters.js') !!}
		<script>
			// Destroy all modals when they're hidden
			$('.modal').on('hidden.bs.modal', function()
			{
				$('.modal').removeData('bs.modal')
			})

			// Re-compile Vue when a modal is loaded so we can use components in the modal
			$('.modal').on('loaded.bs.modal', function()
			{
				vm.$compile($(this).get(0))
			})

			/*// Setup the CSRF token on Ajax requests
			$.ajaxPrefilter(function (options, originalOptions, xhr) {
				var token = $('meta[name="csrf-token"]').attr('content')

				if (token) {
					return xhr.setRequestHeader('X-CSRF-TOKEN', token)
				}
			})

			// Setup the CSRF token on Ajax requests
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			})

			$(document).ajaxError(function(event, xhr, settings, thrownError) {
				if (xhr.status == 403) {
					swal({
						title: "Unauthorized!",
						text: "You do not have permission to take this action!",
						type: "error",
						timer: null,
						html: true
					})
				}
			})*/

			var vue = {}
			window.Nova = <?php echo json_encode(Nova::scriptVariables());?>

			@if (session()->has('flash_message'))
				swal({
					title: "{{ session('flash_message.title') }}",
					text: "{{ session('flash_message.message') }}",
					type: "{{ session('flash_message.level') }}",
					timer: 2250,
					showConfirmButton: false,
					html: true
				})
			@endif

			@if (session()->has('flash_message_overlay'))
				swal({
					title: "{{ session('flash_message_overlay.title') }}",
					text: "{{ session('flash_message_overlay.message') }}",
					type: "{{ session('flash_message_overlay.level') }}",
					timer: null,
					confirmButtonText: "OK",
					html: true,
					allowOutsideClick: true
				})
			@endif

			$(function()
			{
				$('.js-tooltip-top').tooltip({ placement: 'top' })
				$('.js-tooltip-bottom').tooltip({ placement: 'bottom' })
				$('.js-tooltip-left').tooltip({ placement: 'left' })
				$('.js-tooltip-right').tooltip({ placement: 'right' })

				$('.editor').summernote({
					height: 250,
					toolbar: [
						['style', ['bold', 'italic', 'underline', 'clear']],
						['font', ['superscript', 'subscript']],
						['fontsize', ['fontsize']],
						['para', ['ul', 'ol', 'paragraph']],
						['insert', ['picture', 'link', 'table', 'hr']],
						['misc', ['codeview']]
					]
				})
			})
		</script>
		{!! $scripts or false !!}
		<script>
			var vm = new Vue({
				el: '#app',
				mixins: [vue],
				http: {
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				}
			})
		</script>
	</body>
</html>