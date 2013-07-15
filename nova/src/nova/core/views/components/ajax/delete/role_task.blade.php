<p>{{ lang('short.deleteConfirm', langConcat('role task'), $task->name) }}</p>

{{ Form::model($task, ['url' => 'admin/role/tasks']) }}
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}