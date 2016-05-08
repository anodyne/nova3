<p>The following {{ Str::plural('user', $role->users->count()) }} {{ ($role->users->count() == 1 ? 'is' : 'are') }} assigned to the <strong>{!! $role->present()->name !!}</strong> role:</p>

<ul>
	@foreach ($role->users as $user)
		<li>{!! $user->present()->name !!}</li>
	@endforeach
</ul>