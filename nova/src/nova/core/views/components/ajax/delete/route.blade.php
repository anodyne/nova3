<p>{{ lang('short.admin.pages.removeConfirm', lang('route'), $route->name) }}</p>

{{ Form::model($route, ['url' => 'admin/routes']) }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'delete') }}
	{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}