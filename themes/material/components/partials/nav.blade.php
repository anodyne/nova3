<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ route('home') }}" class="navbar-brand">{{ $_settings->sim_name }}</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="{{ route('setup.home') }}">Setup Center</a></li>

				@if (Auth::check())
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="{{ route('admin.pages') }}">Page Manager</a></li>
							<li><a href="#">Additional Page Contents</a></li>
							<li><a href="#">Menus</a></li>
						</ul>
					</li>
				@endif
			</ul>

			<ul class="nav navbar-nav navbar-right">
				@if (Auth::check())
					<li><a href="{{ route('logout') }}">Log Out</a></li>
				@else
					<li><a href="{{ route('login') }}">Log In</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>