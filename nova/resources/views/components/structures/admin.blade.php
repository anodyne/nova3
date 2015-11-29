<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Anodyne Productions">
		<meta name="description" content="{{ $pageDescription or $_page->description }}">
		<meta property="og:title" content="{{ $_content->get('sim.name') }}: {{ $pageName or $_page->name }}">
		<meta property="og:description" content="{{ $pageDescription or $_page->description }}">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ $pageTitle or $_page->present()->title }} &bull; {{ $_content->get('sim.name') }}</title>

		{!! partial('include-bootstrap-css') !!}
		{!! HTML::style('nova/resources/css/sweetalert.css') !!}
		{!! partial('include-fonts') !!}
		{!! partial('include-icons') !!}

		@if (app('files')->exists(theme_path('design/css/icons.css', false)))
			{!! HTML::style(theme_path('design/css/icons.css')) !!}
		@else
			{!! HTML::style('nova/resources/views/design/css/base.icons.css') !!}
		@endif

		@if (app('files')->exists(theme_path('design/css/style.css', false)))
			{!! HTML::style(theme_path('design/css/style.css')) !!}
		@else
			{!! HTML::style('nova/resources/views/design/css/base.style.css') !!}
		@endif

		{!! HTML::style('nova/resources/views/design/css/base.responsive.css') !!}

		@if (app('files')->exists(theme_path('design/css/custom.css', false)))
			{!! HTML::style(theme_path('design/css/custom.css')) !!}
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

		{!! partial('include-jquery') !!}
		{!! partial('include-bootstrap-js') !!}
		{!! HTML::script('nova/resources/js/functions.js') !!}
		{!! partial('sweetalert') !!}
		<script>
			var vue = {}
			
			// Setup the CSRF token on Ajax requests
			$.ajaxPrefilter(function(options, originalOptions, xhr)
			{
				var token = $('meta[name="csrf-token"]').attr('content')

				if (token)
					return xhr.setRequestHeader('X-CSRF-TOKEN', token)
			})

			// Setup the CSRF token on Ajax requests
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			})

			$(document).ajaxError(function(event, xhr, settings, thrownError)
			{
				if (xhr.status == 403)
				{
					swal({
						title: "Unauthorized!",
						text: "You do not have permission to take this action!",
						type: "error",
						timer: null,
						html: true
					})
				}
			})
		</script>
		{!! $javascript or false !!}
		{!! partial('include-vue') !!}
	</body>
</html>