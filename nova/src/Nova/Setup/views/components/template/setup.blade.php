<header>
	<div class="container">
		<div class="logo"></div>
	</div>
</header>

<section>
	<div class="container">
		<div class="head">
			@if (isset($steps))
				<div id="steps">{{{ $steps }}}</div>
			@endif
			<h1>{{{ $label }}}</h1>
			<div style="clear:both;"></div>
		</div>
		
		<div class="content">
			<div id="loaded">
				{{{ $flash }}}
				{{{ $content }}}
			</div>
		</div>
		
		@if ($controls !== false)
			<div class="lower">
				{{{ $controls }}}
			</div>
		@endif
	</div>
</section>

<footer>
	&copy; {{ date('Y') }} Anodyne Productions
</footer>