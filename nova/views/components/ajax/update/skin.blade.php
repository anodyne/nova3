<p><?php echo lang('short.updateConfirm', lang('skin'), $skin->name);?></p>

{{ Form::open(['url' => 'admin/catalog/skins']) }}
	{{ Form::token() }}
	{{ Form::hidden('id', $skin->id) }}
	{{ Form::hidden('formAction', 'version') }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}