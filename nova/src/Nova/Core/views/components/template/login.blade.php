<noscript>
	<div class="alert system-warning"><div class="container">@lang('short.javascript')</div></div>
</noscript>

<div class="container">
	<div class="page-header">
		<h1>{{ $header }}</h1>
	</div>

	<p>{{ $message }}</p>

	{{ $flash }}
	{{ $content }}

	<footer>
		&copy; {{ date('Y') }} Anodyne Productions
	</footer>
</div>