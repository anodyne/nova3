<p>{{ lang('short.deleteConfirm', langConcat('role task'), $task->name) }}</p>

{{ Form::model($task, ['url' => 'admin/role/tasks']) }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'delete') }}
	{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}