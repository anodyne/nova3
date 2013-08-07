<p>{{ lang('short.users.remove', $user->name, lang('characters')) }}</p>

{{ Form::model($user, ['url' => 'admin/user']) }}
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}