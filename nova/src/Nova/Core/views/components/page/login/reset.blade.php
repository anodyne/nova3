{{ Form::open() }}
	<div class="control-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
		<label class="control-label">{{ ucwords(lang("email_address")) }}</label>
		<div class="controls">
			{{ Form::email('email', null, array('class' => 'span6 input-with-feedback')) }}
			{{ $errors->first('email', '<p class="text-danger">:message</p>') }}
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