<header><img src="{{ SRCURL }}Setup/views/design/images/logo.png" alt=""></header>

<div class="outer-container">
	<div class="container">
		<div class="head">
			@if (isset($steps))
				<div id="steps">{{{ $steps }}}</div>
			@endif
			<h1>{{{ $image.$label }}}</h1>
			<div style="clear:both;"></div>
		</div>
		
		<div class="content">
			<div id="loading" class="hide">
				<div class="cssanimations">
					<p class="fs1 fgc1">
						<span class="loading1" data-icon1="%" data-icon2="&"></span>
						<span class="fgc1 visuallyhidden">Loading...</span>
					</p>
				</div>
			</div>
			
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
</div>

<footer>
	&copy; {{ date('Y') }} Anodyne Productions
</footer>