<p><?php echo lang('short.duplicateConfirm', langConcat('system page'), $route->name);?></p>

{{ Form::open(['url' => 'admin/main/pages']) }}
	<div class="controls">
		{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		
		{{ Form::hidden('id', $route->id) }}
		{{ Form::hidden('action', 'duplicate') }}
	</div>
{{ Form::close() }}