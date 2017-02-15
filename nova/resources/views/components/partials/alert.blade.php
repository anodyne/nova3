<div class="alert alert-{{ $level }}" role="alert">
	@if ($header)
		<h4 class="alert-heading">{{ $header }}</h4>
	@endif

	{!! $content !!}
</div>