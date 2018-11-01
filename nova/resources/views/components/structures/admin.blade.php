<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ $pageTitle ?? '' }} &bull; {{ config('app.name', 'Laravel') }}</title>

	<script defer src="{{ asset('assets/js/fa-solid.min.js') }}"></script>
	<script src="{{ asset('assets/js/fontawesome.min.js') }}"></script>

	<!-- Styles -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
	<link href="{{ asset('assets/css/vendor.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
	{!! $styles ?? false !!}

	<script>
		window.Nova = {!! json_encode(Nova::scriptVariables()) !!}
	</script>
	@routes
</head>
<body class="font-sans bg-grey-lighter text-grey-dark">
	<div id="nova-app">
		{!! $template ?? false !!}
	</div>

	<!-- Scripts -->
	<script src="{{ asset('assets/js/manifest.js') }}"></script>
	<script src="{{ asset('assets/js/vendor.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script>
		var vue = {}

		$(function () {
			// $('[data-toggle="tooltip"]').tooltip({
			// 	container: 'body',
			// 	html: true
			// })

			// $('[data-toggle="popover"]').popover({
			// 	container: 'body',
			// 	html: true
			// })
		})
	</script>
	{!! $scripts ?? false !!}
	<script>
		const app = new Vue({
			el: '#nova-app',
			mixins: [vue]
		})
	</script>
</body>
</html>
