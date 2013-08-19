{{ Form::open() }}
	<div class="form-group">
		{{ Form::email('email', null, ['class' => 'input-with-feedback form-control input-lg', 'placeholder' => ucwords(lang('email_address'))]) }}
	</div>

	{{ Form::token() }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}
	
	{{ HTML::link('login', lang('short.cancelPasswordReset'), ['class' => 'btn btn-block btn-default']) }}
{{ Form::close() }}