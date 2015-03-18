<!DOCTYPE html>
<html lang="en" ng-app="app">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Anodyne Productions">
		<meta name="description" content="{{ $_page->description }}">
		<meta property="og:title" content="{{ $_settings->sim_name }}: {{ $_page->name }}">
        <meta property="og:description" content="{{ $_page->description }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ $_page->present()->title }} &bull; {{ $_settings->sim_name }}</title>

		@if (app('files')->exists(themePath('design/css/bootstrap.css', false)))
			{!! HTML::style(app()->themeRelativePath('design/css/bootstrap.css')) !!}
		@else
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
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

		@if ($_currentUser and $_currentUser->preference('theme_variant'))
			{!! HTML::style(themePath("design/css/variants/{$_currentUser->preference('theme_variant')}.css")) !!}
		@endif
	</head>
	<body>
		{!! $template or '' !!}

		<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>

		@if (app('files')->exists(themePath('design/js/bootstrap.js', false)))
			{!! HTML::script(app()->themeRelativePath('design/js/bootstrap.js')) !!}
		@else
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		@endif

		<script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		</script>
		
		{!! $javascript or '' !!}
	</body>
</html>