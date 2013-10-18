<p><?php echo lang('short.installConfirm', lang('skin'), $skin->name);?></p>

{{ Form::open(['url' => 'admin/catalog/skins']) }}
	{{ Form::token() }}
	{{ Form::hidden('location', $skin->location) }}
	{{ Form::hidden('formAction', 'install') }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}