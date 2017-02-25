<div class="page-header">
	<h1>Icons ({{ count($icons) }} icons)</h1>
</div>

<div class="row">
	@foreach ($icons as $key => $value)
		<div class="col-md-2 text-center">
			<div>{!! icon($key, 'x2') !!}</div>
			<small class="text-muted">{{ $key }}</small>
		</div>
	@endforeach
</div>