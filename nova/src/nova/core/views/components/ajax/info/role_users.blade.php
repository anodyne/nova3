@if ($users->count() > 0)
	<dl>
	@foreach ($users as $u)
		<dt>{{ $u->name }}</dt>
		<dd class="text-muted text-small">{{ $u->email }}</dd>
		<dd class="text-muted text-small">{{ $u->getPrimaryCharacter()->getNameWithRank() }}</dd>
	@endforeach
	</dl>
@else
	<p class="alert">{{ lang('error.notFound', lang('users')) }}</p>
@endif