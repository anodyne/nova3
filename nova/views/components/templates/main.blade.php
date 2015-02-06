<div class="container">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="{{ route('home') }}" class="navbar-brand">{{ $siteName }}</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ route('setup.home') }}">Setup Center</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="{{ route('admin.pages') }}">Page Manager</a></li>
							<li><a href="#">Additional Page Contents</a></li>
							<li><a href="#">Menus</a></li>
						</ul>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="{{ route('login') }}">Log In</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<main>
		@if ($header)
			<div class="page-header">
				<h1>{!! $header !!}</h1>
			</div>
		@endif

		@if ($message)
			{!! $message !!}
		@endif

		{!! $content or '' !!}
	</main>

	<footer>
		{!! $footer or '' !!}
	</footer>
</div>