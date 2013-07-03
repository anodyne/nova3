<div class="navbar">
	<div class="container">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<a href="{{ URL::to('/') }}" class="navbar-brand">{{ $name }}</a>

		<div class="nav-collapse collapse navbar-responsive-collapse">
			<ul class="nav navbar-nav">
			@foreach ($items as $item)
				<?php

				// get the url segments
				$segments = explode('/', $item->url);

				// get the first item of the URI
				$first = strtolower(Route::getController());

				// class output
				$activeOutput = ($segments[0] == $first) ? ' class="active"' : false;

				// figure out what should be shown
				$targetOutput = ($item->url_target == 'offsite') ? ' target="_blank"' : false;

				?><li{{ $activeOutput }}>{{ HTML::link($item->url, $item->name) }}</li>
			@endforeach
			</ul>
		</div>
	</div>
</div>