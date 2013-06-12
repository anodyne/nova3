{{ Form::open() }}
	<div class="control-group">
		<div class="controls">
			{{ Form::email('email', null, ['class' => 'input-with-feedback', 'placeholder' => ucwords(lang("email_address"))]) }}
		</div>
	</div>

	{{ Form::token() }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary btn-large btn-block']) }}
	
	{{ HTML::link('login', lang('short.cancelPasswordReset'), ['class' => 'btn btn-default btn-block']) }}
{{ Form::close() }}