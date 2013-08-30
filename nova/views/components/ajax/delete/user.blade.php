<p>{{ lang('short.admin.users.remove', $user->name, lang('characters')) }}</p>

@if ($user->characters->count() > 0)
	<p class="text-small text-muted">{{ lang('short.admin.users.removeCharacters') }}</p>

	<ul class="text-small text-muted">
	@foreach ($user->characters as $character)
		<li>{{ $character->getNameWithRank() }}</li>
	@endforeach
	</ul>
@endif

{{ Form::model($user, ['url' => 'admin/user']) }}
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}