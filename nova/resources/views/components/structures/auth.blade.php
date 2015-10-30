<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Anodyne Productions">
		<meta name="description" content="{{ $pageDescription or $_page->description }}">
		<meta property="og:title" content="{{ $_content->get('sim.name') }}: {{ $pageName or $_page->name }}">
		<meta property="og:description" content="{{ $pageDescription or $_page->description }}">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>{{ $pageTitle or $_page->present()->title }} &bull; {{ $_content->get('sim.name') }}</title>
		
		@if (app('files')->exists(theme_path('design/css/bootstrap.css', false)))
			{!! HTML::style(theme_path('design/css/bootstrap.css')) !!}
		@else
			<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		@endif

		{!! HTML::style('nova/resources/css/sweetalert.css') !!}
		{!! partial('include-fonts') !!}
		{!! partial('include-icons') !!}
		
		@if (app('files')->exists(theme_path('design/css/auth.style.css', false)))
			{!! HTML::style(theme_path('design/css/auth.style.css')) !!}
		@else
			{!! HTML::style('nova/resources/views/design/css/base.style.css') !!}
			{!! HTML::style('nova/resources/views/design/css/auth.style.css') !!}
		@endif
		
		@if (app('files')->exists(theme_path('design/css/auth.custom.css', false)))
			{!! HTML::style(theme_path('design/css/auth.custom.css')) !!}
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
		{!! HTML::script('nova/resources/js/sweetalert.min.js') !!}
		{!! partial('sweetalert') !!}
		{!! $javascript or false !!}
	</body>
</html>