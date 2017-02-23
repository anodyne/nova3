<nav class="navbar navbar-toggleable-md navbar-light bg-faded mb-3">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a href="{{ route('home') }}" class="navbar-brand">{{ $_content->get('sim.name') }}</a>
	
	<div id="navbar" class="navbar-collapse collapse">
		{!! MenuBuilder::menuCombined() !!}
		{!! MenuBuilder::menuUser() !!}
	</div>
</nav>