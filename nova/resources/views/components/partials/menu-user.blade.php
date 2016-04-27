<ul class="nav navbar-nav navbar-right">
	@if (Auth::check())
		<li><a href="#">{!! icon('notifications') !!}</a></li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $_user->present()->name }} <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="#">My Account</a></li>
				<li><a href="{{ route('admin.users.preferences') }}">My Preferences</a></li>
				<!--<li><a href="#">My Characters</a></li>
				<li class="divider"></li>
				<li><a href="#">Messages</a></li>
				<li><a href="#">Notifications</a></li>-->
				<li class="divider"></li>
				<li><a href="{{ route('logout') }}">Log Out</a></li>
			</ul>
		</li>
	@else
		<li><a href="{{ route('login') }}">Log In</a></li>
	@endif
</ul>