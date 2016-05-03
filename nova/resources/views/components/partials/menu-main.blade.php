<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ route('home') }}" class="navbar-brand">{{ $_content->get('sim.name') }}</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			{!! MenuBuilder::mainMenu() !!}
			{!! MenuBuilder::userMenu() !!}
		</div>
	</div>
</nav>