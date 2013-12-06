@if ($similarRoutes)
	<p>{{ lang('short.admin.routes.removeConfirm', lang('route'), $route->name) }}</p>
@else
	<p>{{ lang('short.admin.routes.removeConfirmNoCoreRoute', lang('route'), $route->name) }}</p>
@endif

{{ Form::model($route, ['url' => 'admin/routes']) }}
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('formAction', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}