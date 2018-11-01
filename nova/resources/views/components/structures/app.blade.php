<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ $pageTitle ?? '' }} &bull; {{ config('app.name', 'Nova') }}</title>

	{!! $entryBeforeHead ?? false !!}

	{!! partial('icons') !!}
	{!! partial('fonts') !!}

	<link href="{{ asset('assets/css/vendor.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
	{!! $styles ?? false !!}

	<script>
		window.config = Object.freeze({!! Nova::scriptVariables()->toJson() !!})
	</script>
	@routes

	{!! $entryAfterHead ?? false !!}
</head>
<body>
	<div id="nova-app">
		{!! $entryBeforeLayout ?? false !!}

		{!! $layout ?? false !!}

		{!! $entryAfterLayout ?? false !!}
	</div>

	<!-- Sprite Map -->
	{!! $spriteMap ?? false !!}

	<!-- Scripts -->
	<script src="{{ asset('assets/js/manifest.js') }}"></script>
	<script src="{{ asset('assets/js/vendor.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script>
		feather.replace()

		window.Nova = new CreateNova(config)
	</script>
	{!! $scripts ?? false !!}
	<script>
		Nova.run()
	</script>
</body>
</html>
