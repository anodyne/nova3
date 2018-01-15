<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
	<a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
	<button class="navbar-toggler"
			type="button"
			data-toggle="collapse"
			data-target="#navbarSupportedContent"
			aria-controls="navbarSupportedContent"
			aria-expanded="false"
			aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<div class="navbar-nav mr-auto">
			<a class="nav-item nav-link" href="{{ route('home') }}"><i class="fa fa-home fa-fw"></i> Home</a>
			<a class="nav-item nav-link" href="{{ route('characters.manifest') }}"><i class="fa fa-users fa-fw"></i> Manifest</a>
			<div class="nav-item dropdown">
				<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					<i class="fa fa-cogs fa-fw"></i> Admin <span class="caret"></span>
				</a>

				<div class="dropdown-menu">
					<a class="dropdown-item" href="{{ route('extensions.index') }}">Extensions</a>
					<a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route('departments.index') }}">Departments</a>
					<a class="dropdown-item" href="{{ route('positions.index') }}">Positions</a>
					<a class="dropdown-item" href="{{ route('ranks.index') }}">Ranks</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route('characters.index') }}">Characters</a>
					<a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
					<a class="dropdown-item" href="{{ route('users.index') }}">Users</a>
				</div>
			</div>
		</div>

		<div class="navbar-nav">
			@if (Auth::guest())
				<a class="nav-item nav-link" href="{{ route('sign-in') }}">{{ _m('sign-in') }}</a>
				<a class="nav-item nav-link" href="{{ route('join') }}">Register</a>
			@else
				<div class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" role="button" aria-expanded="false">
						<span class="mr-1">
							<avatar :item="{{ $_user }}"
									:show-content="false"
									:show-status="false"
									size="xs"
									type="image">
							</avatar>
						</span>
						<span class="caret"></span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="{{ route('profile.show', [$_user]) }}">{{ _m('users-my-profile') }}</a>
						<a class="dropdown-item" href="{{ route('profile.edit', [$_user]) }}">{{ _m('users-profile-update') }}</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('dashboard.characters') }}">{{ _m('dashboard-characters') }}</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('sign-out') }}"
						   onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
							{{ _m('sign-out') }}
						</a>

						<form id="logout-form" action="{{ route('sign-out') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</div>
			@endif
		</div>
	</div>
</nav>

<main v-cloak>
	<div class="container">
		{!! $content or false !!}

		@if (app()->environment() == 'local')
			<span class="badge badge-dark d-sm-none">xs</span>
			<span class="badge badge-info d-none d-sm-inline d-md-none">sm</span>
			<span class="badge badge-warning d-none d-md-inline d-lg-none">md</span>
			<span class="badge badge-success d-none d-lg-inline d-xl-none">lg</span>
			<span class="badge badge-danger d-none d-xl-inline">xl</span>
		@endif
	</div>
</main>

<flash message="{{ session('flash.message') }}"
	   title="{{ session('flash.title') }}"
	   level="{{ session('flash.level') }}"></flash>