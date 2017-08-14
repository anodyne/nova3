<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<script defer src="{{ asset('assets/js/packs/regular.js') }}"></script>
	<script defer src="{{ asset('assets/js/fontawesome.js') }}"></script>

	<!-- Styles -->
	<link href="{{ asset('assets/css/vendor.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="nova-app">
		<div class="container">
			<div class="row justify-content-around">
				<div class="col-xs-12 col-md-6 col-lg-4">
					@if (session()->has('flash'))
						<div class="alert alert-{{ session('flash.level') }}">
							@if (session('flash.title'))
								<h4 class="alert-heading">{{ session('flash.title') }}</h4>
							@endif

							<p>{{ session('flash.message') }}</p>
						</div>
					@endif

					@yield('content')
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="{{ asset('assets/js/manifest.js') }}"></script>
	<script src="{{ asset('assets/js/vendor.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script>var vue = {}</script>
	@yield('js')
	<script>
		const app = new Vue({
			el: '#nova-app',
			mixins: [vue]
		})
	</script>
</body>
</html>
