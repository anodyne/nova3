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
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
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
								<a class="dropdown-item" href="{{ route('departments.index') }}">Departments</a>
								<a class="dropdown-item" href="{{ route('positions.index') }}">Positions</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
								<a class="dropdown-item" href="{{ route('permissions.index') }}">Permissions</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('users.index') }}">Users</a>
							</div>
						</div>
					</div>
					
					<div class="navbar-nav">
						@if (Auth::guest())
							<a class="nav-item nav-link" href="{{ route('login') }}">{{ _m('sign-in') }}</a>
							<a class="nav-item nav-link" href="{{ route('join') }}">Register</a>
						@else
							<div class="nav-item dropdown">
								<a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" role="button" aria-expanded="false">
									<span class="mr-1"><avatar :user="{{ $_user }}" type="image" size="xs"></avatar></span>
									{{-- {{ $_user->present()->name }} --}}
									<span class="caret"></span>
								</a>

								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="{{ route('profile.show', [$_user]) }}">{{ _m('user-my-profile') }}</a>
									<a class="dropdown-item" href="{{ route('profile.edit', [$_user]) }}">{{ _m('user-profile-update') }}</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="{{ route('logout') }}"
									   onclick="event.preventDefault();
												document.getElementById('logout-form').submit();">
										{{ _m('sign-out') }}
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

		<main v-cloak>
			<div class="container">
				@yield('content')
			</div>
		</main>

		<flash message="{{ session('flash.message') }}"
			   title="{{ session('flash.title') }}"
			   level="{{ session('flash.level') }}"></flash>
	</div>

	<!-- Scripts -->
	<script src="{{ asset('assets/js/manifest.js') }}"></script>
	<script src="{{ asset('assets/js/vendor.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
	@stack('scripts')
	<script>
		var vue = {}

		$(function () {
			$('[data-toggle="tooltip"]').tooltip({
				container: 'body',
				html: true
			})

			$('[data-toggle="popover"]').popover({
				container: 'body',
				html: true
			})
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
