<div class="navbar">
	<div class="container">
		{{ HTML::link('/', $name, array('class' => 'navbar-brand')) }}

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