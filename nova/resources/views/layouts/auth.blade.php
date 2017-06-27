<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<script defer src="{{ asset('resources/js/packs/regular.js') }}"></script>
	<script defer src="{{ asset('resources/js/fontawesome.js') }}"></script>

	<!-- Styles -->
	<link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		@yield('content')
	</div>

	<!-- Scripts -->
	<script src="{{ asset('resources/js/manifest.js') }}"></script>
	<script src="{{ asset('resources/js/vendor.js') }}"></script>
	<script src="{{ asset('resources/js/app.js') }}"></script>
	<script>var vue = {}</script>
	@yield('js')
	<script>
		const app = new Vue({
			el: '#app',
			mixins: [vue]
		})
	</script>
</body>
</html>
