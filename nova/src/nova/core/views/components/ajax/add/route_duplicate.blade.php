<p><?php echo lang('short.duplicateConfirm', lang('route'), $route->name);?></p>

{{ Form::open(['url' => 'admin/routes']) }}
	{{ Form::hidden('id', $route->id) }}
	{{ Form::hidden('action', 'duplicate') }}
	{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}