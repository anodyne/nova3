@if ($_page and $_page->header() and ! empty($_page->header()->value))
	<div class="page-header">
		<h1>{!! $_page->present()->header !!}</h1>
	</div>
@endif

@if ($_page and $_page->message() and ! empty($_page->message()->value))
	{!! $_page->present()->message !!}
@endif