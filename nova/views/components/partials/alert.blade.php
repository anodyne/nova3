<div class="alert alert-{{ $level }}">
	@if ($header)
		<h4>{{ $header }}</h4>
	@endif

	{!! $content !!}
</div>