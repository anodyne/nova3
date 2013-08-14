{{ Form::open() }}
	<div class="form-group">
		{{ Form::email('email', null, ['class' => 'input-with-feedback form-control', 'placeholder' => ucwords(lang('email_address'))]) }}
	</div>

	{{ Form::token() }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) }}
	
	{{ HTML::link('login', lang('short.cancelPasswordReset'), ['class' => 'btn btn-default btn-block']) }}
{{ Form::close() }}