<p>{{ lang('short.deleteConfirm', langConcat('role task'), $task->name) }}</p>

{{ Form::model($task, array('url' => 'admin/role/tasks', 'method' => 'delete')) }}
	
	{{ Form::hidden('id') }}

	{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary')) }}

{{ Form::close() }}