@if ($roles->count() > 0)
	<dl>
	@foreach ($roles as $r)
		<dt>{{ $r->name }}</dt>
		<dd class="text-muted text-small">{{ $r->desc }}</dd>
	@endforeach
	</dl>
@else
	<p class="alert">{{ lang('error.notFound', langConcat('access roles')) }}</p>
@endif