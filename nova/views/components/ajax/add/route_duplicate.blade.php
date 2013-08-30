<p>{{ lang('short.duplicateConfirm', lang('route'), $route->name) }}</p>

{{ Form::model($route, ['url' => 'admin/routes']) }}
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'duplicate') }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}