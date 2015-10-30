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

		@if (app('files')->exists(theme_path('design/css/bootstrap.css', false)))
			{!! HTML::style(theme_path('design/css/bootstrap.css')) !!}
		@else
			<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		@endif

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

		<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		{!! partial('include-vue') !!}
		{!! HTML::script('nova/resources/js/sweetalert.min.js') !!}
		{!! partial('sweetalert') !!}
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
					});
				}
				console.log(event);
				console.log(xhr);
				console.log(settings);
				console.log(thrownError);
				console.log(xhr.getResponseHeader('foo'));
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