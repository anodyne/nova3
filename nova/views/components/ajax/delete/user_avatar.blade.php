<p>{{ lang('short.admin.users.removeAvatar', lang('user'), $user->name) }}</p>

{{ Form::model($user, ['url' => "admin/user/avatar", 'method' => 'delete']) }}
	{{ Form::hidden('id') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}