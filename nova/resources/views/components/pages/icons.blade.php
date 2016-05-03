<div class="page-header">
	<h1>Icons</h1>
</div>

<div class="row">
	@foreach ($icons as $key => $value)
		<div class="col-md-2 text-center">
			<div>{!! icon($key, 'md') !!}</div>
			<p class="text-muted">{{ $key }}</p>
		</div>
	@endforeach
</div>