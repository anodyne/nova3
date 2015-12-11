@if ($sections->count() > 0)
	@foreach ($sections->sortBy('order') as $section)
		<h3>{!! $section->present()->name !!}</h3>
	@endforeach
@endif