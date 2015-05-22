<!DOCTYPE html>
<html lang="en" ng-app="app">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Anodyne Productions">
		<meta name="description" content="{{ $pageDescription or $_page->description }}">
		<meta property="og:title" content="{{ $_settings->sim_name }}: {{ $pageName or $_page->name }}">
		<meta property="og:description" content="{{ $pageDescription or $_page->description }}">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ $pageTitle or $_page->present()->title }} &bull; {{ $_settings->sim_name }}</title>

		@if (app('files')->exists(themePath('design/css/bootstrap.css', false)))
			{!! HTML::style(app()->themeRelativePath('design/css/bootstrap.css')) !!}
		@else
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
		@endif

		{!! partial('fonts') !!}

		@if (app('files')->exists(themePath('design/css/icons.css', false)))
			{!! HTML::style(app()->themeRelativePath('design/css/icons.css')) !!}
		@else
			{!! HTML::style('nova/views/design/css/base.icons.css') !!}
		@endif

		@if (app('files')->exists(themePath('design/css/style.css', false)))
			{!! HTML::style(app()->themeRelativePath('design/css/style.css')) !!}
		@else
			{!! HTML::style('nova/views/design/css/base.style.css') !!}
		@endif

		@if (app('files')->exists(themePath('design/css/custom.css', false)))
			{!! HTML::style(themePath('design/css/custom.css')) !!}
		@endif

		@if (user() and user()->preference('theme_variant'))
			{!! HTML::style(themePath("design/css/variants/{user()->preference('theme_variant')}.css")) !!}
		@endif
		@if ( ! user() and ! empty($_settings->theme_variant))
			{!! HTML::style(themePath("design/css/variants/{$_settings->theme_variant}.css")) !!}
		@endif

		{!! $styles or false !!}
	</head>
	<body>
		{!! $template or false !!}

		<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script>
			// Setup the CSRF token on Ajax requests
			$.ajaxPrefilter(function(options, originalOptions, xhr)
			{
				var token = $('meta[name="csrf-token"]').attr('content');

				if (token)
					return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			});

			// Setup the CSRF token on Ajax requests
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Destroy all modals when they're hidden
			$('.modal').on('hidden.bs.modal', function()
			{
				$('.modal').removeData('bs.modal');
			});

			$(function()
			{
				$('.js-tooltip-top').tooltip({ placement: 'top' });
				$('.js-tooltip-bottom').tooltip({ placement: 'bottom' });
				$('.js-tooltip-left').tooltip({ placement: 'left' });
				$('.js-tooltip-right').tooltip({ placement: 'right' });
			});
		</script>
		{!! $javascript or false !!}
	</body>
</html>