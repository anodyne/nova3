<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" integrity="sha384-dNpIIXE8U05kAbPhy3G1cz+yZmTzA6CY8Vg/u2L9xRnHjJiAK76m2BIEaSEV+/aU" crossorigin="anonymous">
	<link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse mb-4">
			<div class="container">
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<div class="navbar-nav mr-auto">
						<a class="nav-item nav-link" href="{{ route('home') }}">Home</a>
						<div class="nav-item dropdown">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								Admin <span class="caret"></span>
							</a>

							<div class="dropdown-menu">
								<a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
								<a class="dropdown-item" href="{{ route('permissions.index') }}">Permissions</a>
								<a class="dropdown-item" href="{{ route('users.index') }}">Users</a>
							</div>
						</div>
					</div>
					
					<div class="navbar-nav">
						@if (Auth::guest())
							<a class="nav-item nav-link" href="{{ route('login') }}">Sign In</a>
							<a class="nav-item nav-link" href="{{ route('join') }}">Register</a>
						@else
							<div class="nav-item dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
									{{ Auth::user()->name }} <span class="caret"></span>
								</a>

								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="{{ route('logout') }}"
									   onclick="event.preventDefault();
												document.getElementById('logout-form').submit();">
										Sign Out
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		</nav>

		<div class="container">
			@if (session()->has('flash'))
				<div class="alert alert-{{ session('flash.level') }}" role="alert">
					@if (session()->has('flash.title'))
						<h4 class="alert-heading">{{ session('flash.title') }}</h4>
						<p>{{ session('flash.message') }}</p>
					@else
						<p>{{ session('flash.title') }}</p>
					@endif
				</div>
			@endif

			@yield('content')
		</div>
	</div>

	<!-- Scripts -->
	<script src="{{ asset('resources/js/app.js') }}"></script>
	<script>
		var vue = {}

		$(function () {
			// $('[data-toggle="tooltip"]').tooltip({
			// 	container: 'body',
			// 	html: true
			// })
		})
	</script>
	@yield('js')
	<script>
		const app = new Vue({
			el: '#app',
			mixins: [vue]
		})
	</script>
</body>
</html>
