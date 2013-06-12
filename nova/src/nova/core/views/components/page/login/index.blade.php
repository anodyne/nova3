{{ Form::open() }}
	<div class="control-group">
		<div class="controls">
			{{ Form::email('email', null, ['placeholder' => ucwords(lang("email_address"))]) }}
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			{{ Form::password('password', ['placeholder' => lang("Password")]) }}
		</div>
	</div>

	{{ Form::token() }}
	{{ Form::button(ucwords(lang('action.login')), ['class' => 'btn btn-primary btn-block btn-large', 'type' => 'submit']) }}
	
	{{ HTML::link('login/reset', lang("short.forgotPassword"), ['class' => 'btn btn-default btn-block']) }}
	{{ HTML::link('/', lang("short.backToSite"), ['class' => 'btn btn-default btn-block']) }}
{{ Form::close() }}