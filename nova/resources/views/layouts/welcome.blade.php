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
	<script defer src="{{ asset('assets/js/packs/light.js') }}"></script>
	<script defer src="{{ asset('assets/js/fontawesome.js') }}"></script>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,600" rel="stylesheet">

	<!-- Styles -->
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

	<!-- Styles -->
	<style>
		html, body {
			background-color: #fff;
			color: #546E7A;
			font-family: 'Raleway', sans-serif;
			font-weight: 300;
			height: 100vh;
			margin: 0;
		}

		.full-height {
			height: 100vh;
		}

		.flex-center {
			align-items: center;
			display: flex;
			justify-content: center;
		}

		.position-ref {
			position: relative;
		}

		.top-right {
			position: absolute;
			right: 10px;
			top: 18px;
		}

		.content {
			text-align: center;
		}

		.title {
			font-size: 84px;
			font-weight: 100;
			color: #259b24;
		}

		.links a {
			color: #546E7A;
			padding: 0 25px;
			font-size: 12px;
			font-weight: 600;
			letter-spacing: .1rem;
			text-decoration: none;
			text-transform: uppercase;
		}

		.links strong {
			font-weight: 600;
		}

		.m-b-md {
			margin-bottom: 30px;
		}

		.dropdown-item {
			padding: 0.5rem 1rem !important;
		}

		.dropdown-menu {
			top: 140%;
		}

		.dropdown-menu-right {
			right: 20px;
		}

		.card {
			margin-bottom: 2rem;

			text-align: left;
			border-width: 2px;
		}

		.card > .card-block ul {
			margin-bottom: 0;
		}

		.card > .card-block ul li {
			font-weight: 400;
		}

		.card-inverse {
			color: #fff;
		}

		.card-outline-success {
			color: #5cb85c;
		}

		.text-subtle {
			opacity: 0.6;
		}
	</style>
</head>
<body>
	<div id="app" class="flex-center position-ref {{ Request::is('/') ? 'full-height' : '' }}">
		@if (Route::has('login'))
			<div class="top-right links">
				@if (Auth::check())
					<a href="{{ route('home') }}">Home</a>
					<span class="dropdown">
						<a class="dropdown-toggle"
						   href="#"
						   id="dropdownMenuLink"
						   data-toggle="dropdown"
						   aria-haspopup="true"
						   aria-expanded="false">
						   Admin
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
							<a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
							<a class="dropdown-item" href="{{ route('permissions.index') }}">Permissions</a>
							<a class="dropdown-item" href="{{ route('users.index') }}">Users</a>
						</div>
					</span>
					<a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        Sign Out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
				@else
					<a href="{{ route('login') }}">Sign In</a>
					<a href="{{ route('join') }}">Register</a>
				@endif
			</div>
		@endif

		<div class="content">
			@yield('content')
		</div>

		<flash message="{{ session('flash.message') }}"
			   title="{{ session('flash.title') }}"
			   level="{{ session('flash.level') }}"></flash>
	</div>

	<script src="{{ asset('assets/js/manifest.js') }}"></script>
	<script src="{{ asset('assets/js/vendor.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
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
