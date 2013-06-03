<noscript>
	<div class="alert system-warning"><div class="container">@lang('short.javascript')</div></div>
</noscript>

{{ $navmain }}

<div class="container">
	<div class="page-header">
		@if (isset($headerKey))
			<h1 class="editable-single" id="{{ $headerKey }}">{{ $header }}</h1>
		@else
			<h1>{{ $header }}</h1>
		@endif
	</div>

	{{ $flash }}

	@if (isset($messageKey))
		<div class="editable-multi" id="{{ $messageKey }}">{{ $message }}</div>
	@else
		<div>{{ $message }}</div>
	@endif

	@if (isset($navsub))
		{{ $navsub }}
	@endif

	{{ $content }}
	{{ $ajax }}

	<footer>
		{{ $footer }}
	</footer>
</div>