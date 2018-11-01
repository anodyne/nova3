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

	<link href="{{ asset('assets/css/vendor.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>
<body class="font-sans bg-grey-lighter text-grey-darkest leading-normal">
	<header class="block relative mb-8">
		<div class="h-1 bg-blue"></div>

		<div class="container">
			<div class="flex justify-between items-center">
				<div>
					@icon('anodyne', ['class' => 'leading-none h-16 w-16'])
				</div>

				<div>
					<div>
						<span class="font-medium text-xl text-grey-dark">
							{{ config('nova.app.name') }} Setup
						</span>
						<span class="font-black text-blue-dark text-xl">@yield('header')</span>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section id="nova-setup">
		<div class="container">
			@yield('content')
		</div>
	</section>

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

		@if (session()->has('flash'))
			swal({
				title: "{{ session('flash.title') }}",
				text: "{{ session('flash.message') }}",
				type: "{{ session('flash.level') }}",
				timer: 2250,
				showConfirmButton: false,
				html: true
			});
		@endif
	</script>
	@yield('js')
	<script>
		const app = new Vue({
			el: '#nova-setup',
			mixins: [vue]
		});
	</script>
</body>
</html>
