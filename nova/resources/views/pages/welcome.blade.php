@extends('layouts.welcome')

@section('content')
	<div id="app" class="flex-center position-ref full-height">
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
			<div class="title m-b-md">
				Laravel
			</div>

			<div class="links m-b-md">
				<a href="https://laravel.com/docs">Documentation</a>
				<a href="https://laracasts.com">Laracasts</a>
				<a href="https://laravel-news.com">News</a>
				<a href="https://forge.laravel.com">Forge</a>
				<a href="https://github.com/laravel/laravel">GitHub</a>
			</div>

			@if (auth()->check())
				<div class="links">
					{{ auth()->user()->name }}, {{ auth()->user()->email }}
				</div>
			@endif
		</div>

		<flash message="{{ session('flash') }}"></flash>
	</div>
@endsection