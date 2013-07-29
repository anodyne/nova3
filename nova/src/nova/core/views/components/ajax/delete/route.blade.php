<p>{{ lang('short.admin.routes.removeConfirm', lang('route'), $route->name) }}</p>

{{ Form::model($route, ['url' => 'admin/routes']) }}
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}