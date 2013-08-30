<p><?php echo lang('short.installConfirm', lang('rank_set'), $rank->name);?></p>

{{ Form::open(['url' => 'admin/catalog/ranks']) }}
	{{ Form::token() }}
	{{ Form::hidden('location', $rank->location) }}
	{{ Form::hidden('action', 'install') }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}