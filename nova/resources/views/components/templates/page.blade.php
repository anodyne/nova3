<nav class="navbar">
	<a href="{{ route('home') }}" class="text-blue navbar-brand">{{ config('app.name', 'Laravel') }}</a>

	<div class="navbar-menu">
		<div class="navbar-start">
			<a class="navbar-link" href="{{ route('home') }}">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13 20v-5h-2v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7.59l-.3.3a1 1 0 1 1-1.4-1.42l9-9a1 1 0 0 1 1.4 0l9 9a1 1 0 0 1-1.4 1.42l-.3-.3V20a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2zm5 0v-9.59l-6-6-6 6V20h3v-5c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v5h3z"/></svg>
				<span>Home</span>
			</a>
			<a class="navbar-link" href="{{ route('characters.manifest') }}">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v2zm1-5a1 1 0 0 1 0-2 5 5 0 0 1 5 5v2a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3zm-2-4a1 1 0 0 1 0-2 3 3 0 0 0 0-6 1 1 0 0 1 0-2 5 5 0 0 1 0 10z"/></svg>
				<span>Manifest</span>
			</a>
			<div class="navbar-item has-dropdown is-hoverable">
				<a class="navbar-link">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 4.58V4c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v.58a8 8 0 0 1 1.92 1.11l.5-.29a2 2 0 0 1 2.74.73l1 1.74a2 2 0 0 1-.73 2.73l-.5.29a8.06 8.06 0 0 1 0 2.22l.5.3a2 2 0 0 1 .73 2.72l-1 1.74a2 2 0 0 1-2.73.73l-.5-.3A8 8 0 0 1 15 19.43V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.58a8 8 0 0 1-1.92-1.11l-.5.29a2 2 0 0 1-2.74-.73l-1-1.74a2 2 0 0 1 .73-2.73l.5-.29a8.06 8.06 0 0 1 0-2.22l-.5-.3a2 2 0 0 1-.73-2.72l1-1.74a2 2 0 0 1 2.73-.73l.5.3A8 8 0 0 1 9 4.57zM7.88 7.64l-.54.51-1.77-1.02-1 1.74 1.76 1.01-.17.73a6.02 6.02 0 0 0 0 2.78l.17.73-1.76 1.01 1 1.74 1.77-1.02.54.51a6 6 0 0 0 2.4 1.4l.72.2V20h2v-2.04l.71-.2a6 6 0 0 0 2.41-1.4l.54-.51 1.77 1.02 1-1.74-1.76-1.01.17-.73a6.02 6.02 0 0 0 0-2.78l-.17-.73 1.76-1.01-1-1.74-1.77 1.02-.54-.51a6 6 0 0 0-2.4-1.4l-.72-.2V4h-2v2.04l-.71.2a6 6 0 0 0-2.41 1.4zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
					<span>Admin</span>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z"/></svg>
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
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z"/></svg>
					</a>

					<div class="navbar-dropdown is-right">
						<a class="navbar-link" href="{{ route('profile.show', [$_user]) }}">{{ _m('users-my-profile') }}</a>
						<a class="navbar-link" href="{{ route('profile.edit', [$_user]) }}">{{ _m('users-profile-update') }}</a>
						<div class="navbar-divider"></div>
						<a class="navbar-link" href="{{ route('dashboard.characters') }}">{{ _m('dashboard-characters') }}</a>
						<div class="navbar-divider"></div>
						<a class="navbar-link" href="{{ route('sign-out') }}"
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