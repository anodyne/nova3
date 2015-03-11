<div class="container">
	{!! $nav or '' !!}

	<main>
		@if (Session::has('flash.level'))
			{!! flash() !!}
		@endif
		
		@if ($_page->header())
			<div class="page-header">
				<h1>{!! $_page->present()->header !!}</h1>
			</div>
		@endif

		@if ($_page->message())
			{!! $_page->present()->message !!}
		@endif

		{!! $content or '' !!}
	</main>

	<footer>
		{!! $footer or '' !!}
	</footer>
</div>