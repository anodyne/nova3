<noscript>
	<div class="alert system-warning"><div class="container">@lang('short.javascript')</div></div>
</noscript>

<div class="container">
	<div class="row">
		<div class="col-span-6 col-offset-3">
			<div class="page-header">
				<h1>{{ $header }}</h1>
			</div>

			{{ $flash }}

			<p>{{ $message }}</p>

			{{ $content }}

			<footer>
				&copy; {{ Date::now()->year }} Anodyne Productions
			</footer>
		</div>
	</div>
</div>