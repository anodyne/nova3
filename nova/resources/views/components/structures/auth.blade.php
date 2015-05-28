<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Anodyne Productions">
		<meta name="description" content="{{ $pageDescription or $_page->description }}">
		<meta property="og:title" content="{{ $_settings->get('sim_name') }}: {{ $pageName or $_page->name }}">
		<meta property="og:description" content="{{ $pageDescription or $_page->description }}">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>{{ $pageTitle or $_page->present()->title }} &bull; {{ $_settings->get('sim_name') }}</title>
		
		@if (app('files')->exists(themePath('design/css/bootstrap.css', false)))
			{!! HTML::style(app()->themeRelativePath('design/css/bootstrap.css')) !!}
		@else
			<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
		@endif

		{!! partial('fonts') !!}
		
		@if (app('files')->exists(themePath('design/css/auth.style.css', false)))
			{!! HTML::style(app()->themeRelativePath('design/css/auth.style.css')) !!}
		@else
			{!! HTML::style('nova/resources/views/design/css/base.style.css') !!}
			{!! HTML::style('nova/resources/views/design/css/auth.style.css') !!}
		@endif
		
		@if (app('files')->exists(themePath('design/css/custom.css', false)))
			{!! HTML::style(themePath('design/css/custom.css')) !!}
		@endif

		@if (user() and user()->preference('theme_variant'))
			{!! HTML::style(themePath("design/css/variants/{user()->preference('theme_variant')}.css")) !!}
		@endif
		@if ( ! user() and ! empty($_settings->get('theme_variant')))
			{!! HTML::style(themePath("design/css/variants/{$_settings->get('theme_variant')}.css")) !!}
		@endif

		{!! $styles or false !!}
	</head>
	<body>
		{!! $template or false !!}

		<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		{!! $javascript or false !!}
	</body>
</html>