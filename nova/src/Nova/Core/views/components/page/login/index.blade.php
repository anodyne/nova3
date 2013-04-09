{{ Form::open() }}
	<div class="control-group">
		<label class="control-label">{{ ucwords(lang("base.email_address")) }}</label>
		<div class="controls">
			{{ Form::email('email', null, array('class' => 'span6')) }}
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label">{{ ucfirst(lang("base.password")) }}</label>
		<div class="controls">
			{{ Form::password('password', array('class' => 'span6')) }}
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			{{ Form::button(ucwords(lang('action.login')), array('class' => 'btn btn-primary btn-block btn-large')) }}
			{{ Html::link('login/reset', lang("short.forgotPassword"), array('class' => 'btn btn-block')) }}
			{{ Html::link('main/index', lang("short.backToSite"), array('class' => 'btn btn-block')) }}
		</div>
	</div>
	{{ Form::hidden('_token', csrf_token()) }}
{{ Form::close() }}