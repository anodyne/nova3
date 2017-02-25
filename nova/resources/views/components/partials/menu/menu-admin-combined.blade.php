<nav class="navbar navbar-toggleable-md navbar-light bg-faded mb-3">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a href="{{ route('home') }}" class="navbar-brand">{{ $_content->get('sim.name') }}</a>
	
	<div class="navbar-collapse collapse" id="navbarToggler">
		{!! MenuBuilder::menuCombined() !!}
		{!! MenuBuilder::menuUser() !!}
	</div>
</nav>