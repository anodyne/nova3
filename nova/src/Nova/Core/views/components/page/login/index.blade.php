{{ Form::open() }}
	<div class="control-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
		<label class="control-label">{{ ucwords(lang("email_address")) }}</label>
		<div class="controls">
			{{ Form::email('email', null, array('class' => 'span6 input-with-feedback')) }}
			{{ $errors->first('email', '<p class="text-danger">:message</p>') }}
		</div>
	</div>
	
	<div class="control-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
		<label class="control-label">{{ ucfirst(lang("password")) }}</label>
		<div class="controls">
			{{ Form::password('password', array('class' => 'span6 input-with-feedback')) }}
			{{ $errors->first('password', '<p class="text-danger">:message</p>') }}
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			{{ Form::button(ucwords(lang('action.login')), array('class' => 'btn btn-primary btn-block btn-large', 'type' => 'submit')) }}
			{{ Html::link('login/reset', lang("short.forgotPassword"), array('class' => 'btn btn-block')) }}
			{{ Html::link('main/index', lang("short.backToSite"), array('class' => 'btn btn-block')) }}
		</div>
	</div>
	{{ Form::hidden('_token', csrf_token()) }}
{{ Form::close() }}