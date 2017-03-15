<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ $pageTitle or $_page->present()->title }} &bull; {{ $_content->get('sim.name') }}</title>

		{!! partial('metadata', ['metadata' => $_metadata]) !!}
		
		@if (app('files')->exists(theme_path('design/css/bootstrap.css', false)))
			{!! HTML::style(theme_path('design/css/bootstrap.css')) !!}
		@else
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		@endif
		{!! HTML::style('nova/dist/css/all.css') !!}
		{!! partial('fonts-include') !!}
		{!! partial('icons-include') !!}
		
		@if (app('files')->exists(theme_path('design/css/auth.style.css', false)))
			{!! HTML::style(theme_path('design/css/auth.style.css')) !!}
		@else
			{!! HTML::style('nova/dist/css/base.style.css') !!}
			{!! HTML::style('nova/dist/css/auth.style.css') !!}

			@if (app('files')->exists(theme_path('design/css/auth.custom.css', false)))
				{!! HTML::style(theme_path('design/css/auth.custom.css')) !!}
			@endif
		@endif

		@if (app('files')->exists(theme_path('design/css/responsive.css', false)))
			{!! HTML::style(theme_path('design/css/responsive.css')) !!}
		@else
			{!! HTML::style('nova/dist/css/base.responsive.css') !!}

			@if (app('files')->exists(theme_path('design/css/custom.responsive.css', false)))
				{!! HTML::style(theme_path('design/css/custom.responsive.css')) !!}
			@endif
		@endif

		@if (user() and user()->preference('theme_variant'))
			{!! HTML::style(theme_path("design/css/variants/{user()->preference('theme_variant')}.css")) !!}
		@endif
		@if ( ! user() and ! empty($_settings->get('theme_variant')))
			{!! HTML::style(theme_path("design/css/variants/{$_settings->get('theme_variant')}.css")) !!}
		@endif

		{!! $styles or false !!}
	</head>
	<body>
		{!! $template or false !!}

		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/vue@2.2.4"></script>
		<script src="https://unpkg.com/axios@0.15.3/dist/axios.min.js"></script>
		{!! HTML::script('nova/dist/js/all.js') !!}
		<script>
			// Destroy all modals when they're hidden
			$('.modal').on('hidden.bs.modal', function() {
				$('.modal').removeData('bs.modal')
			})

			// Re-compile Vue when a modal is loaded so we can use components in the modal
			$('.modal').on('loaded.bs.modal', function() {
				vm.$compile($(this).get(0))
			})

			var vue = {}
			window.Nova = <?php echo json_encode(Nova::scriptVariables());?>

			@if (session()->has('flash_message'))
				swal({
					title: "{{ session('flash_message.title') }}",
					text: "{{ session('flash_message.message') }}",
					type: "{{ session('flash_message.level') }}",
					timer: 2250,
					showConfirmButton: false
				}).then(function () {}, function (dismiss) {})
			@endif

			@if (session()->has('flash_message_overlay'))
				swal({
					title: "{{ session('flash_message_overlay.title') }}",
					text: "{{ session('flash_message_overlay.message') }}",
					type: "{{ session('flash_message_overlay.level') }}",
					confirmButtonText: "{{ _m('ok') }}",
					confirmButtonClass: 'btn btn-success',
					buttonsStyling: false
				})
			@endif

			$(function() {
				$('.js-tooltip-top').tooltip({ placement: 'top' })
				$('.js-tooltip-bottom').tooltip({ placement: 'bottom' })
				$('.js-tooltip-left').tooltip({ placement: 'left' })
				$('.js-tooltip-right').tooltip({ placement: 'right' })
			})
		</script>
		{!! $scripts or false !!}
		<script>
			var vm = new Vue({
				el: '#app',
				mixins: [vue]
			})
		</script>
	</body>
</html>