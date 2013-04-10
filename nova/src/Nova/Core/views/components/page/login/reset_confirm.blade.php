@if ( ! $confirmed)
	{{ Form::open(array('url' => 'login/reset_confirm/'.$user.'/'.$code)) }}
		<div class="control-group<?php if ($errors->has('password')){ echo ' has-error';}?>">
			<label class="control-label">{{ ucwords(lang("base.password")) }}</label>
			<div class="controls">
				{{ Form::password('password', array('class' => 'span6')) }}
				{{ $errors->first('password', '<p class="help-block text-error">:message</p>') }}
			</div>
		</div>

		<div class="control-group<?php if ($errors->has('password_confirm')){ echo ' has-error';}?>">
			<label class="control-label">{{ ucwords(langConcat("action.confirm base.password")) }}</label>
			<div class="controls">
				{{ Form::password('password_confirm', array('class' => 'span6')) }}
				{{ $errors->first('password_confirm', '<p class="help-block text-error">:message</p>') }}
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				{{ Form::button(ucwords(langConcat('action.confirm base.password action.reset')), array('type' => 'submit', 'class' => 'btn btn-primary btn-large btn-block')) }}
				
				{{ Html::link('login/index', ucwords(lang('action.login')), array('class' => 'btn btn-block')) }}
			</div>
		</div>
		{{ Form::hidden('_token', csrf_token()) }}
	{{ Form::close() }}
@endif