<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Anodyne Productions">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title') &bull; {{ config('nova.app.name') }}</title>

	<script defer src="{{ asset('assets/js/packs/solid.min.js') }}"></script>
	<script defer src="{{ asset('assets/js/fontawesome.min.js') }}"></script>

	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700|Roboto:300,400,500,700" rel="stylesheet">
	<link href="{{ asset('assets/css/vendor.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/setup.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/setup.responsive.css') }}" rel="stylesheet">

	<script>
		window.Nova = {!! json_encode(Nova::scriptVariables()) !!}
	</script>
	@routes
</head>
<body>
	<header>
		<div class="header-border"></div>

		<div class="container">
			<div class="header">
				<div class="header-group">
					@icon('anodyne', ['class' => 'brand'])
				</div>

				<div class="header-group">
					<div class="masthead">
						<span class="product">{{ config('nova.app.name') }} Setup</span>
						<span class="process">@yield('header')</span>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="container">
		<main id="nova-setup">
			<div class="content">
				{!! view("setup.{$_setupType}.{$_setupType}-steps") !!}

				@yield('content')
			</div>

			<div class="controls">
				@yield('controls')
			</div>
		</main>

		@if (app()->environment() == 'local')
			<span class="badge badge-dark d-sm-none">xs</span>
			<span class="badge badge-info d-none d-sm-inline d-md-none">sm</span>
			<span class="badge badge-warning d-none d-md-inline d-lg-none">md</span>
			<span class="badge badge-success d-none d-lg-inline d-xl-none">lg</span>
			<span class="badge badge-danger d-none d-xl-inline">xl</span>
		@endif
	</div>

	<footer>
		<div class="container">
			&copy; {{ Date::now()->year }} Anodyne Productions
		</div>
	</footer>

	<!-- Scripts -->
	<script src="{{ asset('assets/js/manifest.js') }}"></script>
	<script src="{{ asset('assets/js/vendor.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
	@stack('scripts')
	<script>
		var vue = {};

		$(function () {
			$('[data-toggle="tooltip"]').tooltip({
				container: 'body',
				html: true
			});

			$('[data-toggle="popover"]').popover({
				container: 'body',
				html: true
			});
		});
	</script>
	@yield('js')
	<script>
		const app = new Vue({
			el: '#nova-setup',
			mixins: [vue]
		});
	</script>
</html>