@if ($_page->header() and ! empty($_page->header()->value))
	<div class="page-header">
		<h1>{!! $_page->present()->header !!}</h1>
	</div>
@endif