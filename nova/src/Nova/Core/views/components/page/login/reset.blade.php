{{ Form::open() }}
	<div class="control-group">
		<label class="control-label">{{ ucwords(lang("base.email_address")) }}</label>
		<div class="controls">
			{{ Form::email('email', null, array('id' => 'email', 'class' => 'span6')) }}
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary btn-large btn-block')) }}
			
			{{ Html::link('login/index', lang('short.cancelPasswordReset'), array('class' => 'btn btn-block')) }}
		</div>
	</div>
	{{ Form::hidden('_token', csrf_token()) }}
{{ Form::close() }}