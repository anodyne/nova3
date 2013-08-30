<header>
	<div class="container">
		<div class="logo"></div>
	</div>
</header>

<section>
	<div class="container">
		<div class="head">
			@if (isset($steps))
				<div id="steps">{{ $steps }}</div>
			@endif
			<h1>{{ $header }}</h1>
			<div style="clear:both;"></div>
		</div>
		
		<div class="content">
			<div id="loaded">
				{{ $flash }}
				{{ $content }}
			</div>

			<div id="loading" class="hide">
				<h2><img src="{{ URL::asset('nova/views/design/images/loading.gif') }}" alt=""><small>Loading...</small></h2>
			</div>
		</div>
		
		@if ($controls !== false)
			<div class="lower">
				{{ $controls }}
			</div>
		@endif
	</div>
</section>

<footer>
	&copy; {{ Date::now()->year }} Anodyne Productions
</footer>