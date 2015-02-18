<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Anodyne Productions">
		<meta name="description" content="{{ $_page->description }}">
		<meta name="viewport" content="width=device-width">

		<title>{{ $pageTitle }} &bull; {{ $siteName }}</title>
		
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
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

		@if ($_currentUser->preference('theme_variant'))
			{!! HTML::style(themePath("design/css/variants/{$_currentUser->preference('theme_variant')}.css")) !!}
		@endif
	</head>
	<body>
		{!! $template or '' !!}

		<script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		{!! $javascript or '' !!}
	</body>
</html>