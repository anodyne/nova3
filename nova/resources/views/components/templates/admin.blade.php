<nav class="navbar">
	<a href="{{ route('home') }}" class="text-blue navbar-brand">{{ config('app.name', 'Laravel') }}</a>

	<div class="navbar-menu">
		<div class="navbar-start">
			<a class="navbar-link" href="{{ route('home') }}">
				<icon name="home"></icon>
				<span>Home</span>
			</a>
			<a class="navbar-link" href="{{ route('characters.manifest') }}">
				<icon name="users"></icon>
				<span>Manifest</span>
			</a>
			<div class="navbar-item has-dropdown is-hoverable">
				<a class="navbar-link">
					<icon name="settings"></icon>
					<span>Admin</span>
					<icon name="chevron-down" size="small" classes="ml-1"></icon>
				</a>

				<div class="navbar-dropdown">
					<a class="navbar-item" href="{{ route('extensions.index') }}">Extensions</a>
					<a class="navbar-item" href="{{ route('settings') }}">Settings</a>
					<div class="dropdown-divider"></div>
					<a class="navbar-item" href="{{ route('departments.index') }}">Departments</a>
					<a class="navbar-item" href="{{ route('positions.index') }}">Positions</a>
					<a class="navbar-item" href="{{ route('ranks.index') }}">Ranks</a>
					<div class="dropdown-divider"></div>
					<a class="navbar-item" href="{{ route('characters.index') }}">Characters</a>
					<a class="navbar-item" href="{{ route('roles.index') }}">Roles</a>
					<a class="navbar-item" href="{{ route('users.index') }}">Users</a>
				</div>
			</div>
		</div>

		<div class="navbar-end">
			@if (Auth::guest())
				<a class="navbar-link" href="{{ route('sign-in') }}">{{ _m('sign-in') }}</a>
				<a class="navbar-link" href="{{ route('join') }}">Register</a>
			@else
				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						<avatar :item="{{ $_user }}"
								:show-content="false"
								:show-status="false"
								size="xs"
								type="image"></avatar>
						<icon name="chevron-down" size="small" classes="ml-1"></icon>
					</a>

					<div class="navbar-dropdown is-right">
						<a class="navbar-item" href="{{ route('profile.show', [$_user]) }}">{{ _m('users-my-profile') }}</a>
						<a class="navbar-item" href="{{ route('profile.edit', [$_user]) }}">{{ _m('users-profile-update') }}</a>
						<div class="navbar-divider"></div>
						<a class="navbar-item" href="{{ route('dashboard.characters') }}">{{ _m('dashboard-characters') }}</a>
						<div class="navbar-divider"></div>
						<a class="navbar-item" href="{{ route('sign-out') }}"
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

	<button class="navbar-burger">
		<span></span>
		<span></span>
		<span></span>
	</button>
</nav>

<main v-cloak>
	<div class="container">
		{!! $content or false !!}

		@if (app()->environment() == 'local')
			<span class="hidden mobile:inline-block bg-blue text-white rounded-sm p-1 my-2 text-xs">mobile</span>
			<span class="hidden tablet:inline-block bg-green text-white rounded-sm p-1 my-2 text-xs">tablet</span>
			<span class="hidden desktop:inline-block bg-purple text-white rounded-sm p-1 my-2 text-xs">desktop</span>
		@endif
	</div>
</main>

<flash message="{{ session('flash.message') }}"
	   title="{{ session('flash.title') }}"
	   level="{{ session('flash.level') }}"></flash>