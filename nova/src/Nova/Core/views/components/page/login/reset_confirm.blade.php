@if ( ! $confirmed)
	{{ Form::open(array('url' => 'login/reset_confirm/'.$user.'/'.$code)) }}
		<div class="control-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
			<label class="control-label">{{ ucwords(lang("password")) }}</label>
			<div class="controls">
				{{ Form::password('password', array('class' => 'span6 input-with-feedback')) }}
				{{ $errors->first('password', '<p class="text-danger">:message</p>') }}
			</div>
		</div>

		<div class="control-group {{ ($errors->has('password_confirm')) ? 'has-error' : '' }}">
			<label class="control-label">{{ ucwords(langConcat("action.confirm password")) }}</label>
			<div class="controls">
				{{ Form::password('password_confirm', array('class' => 'span6 input-with-feedback')) }}
				{{ $errors->first('password_confirm', '<p class="text-danger">:message</p>') }}
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				{{ Form::button(ucwords(langConcat('action.confirm password action.reset')), array('type' => 'submit', 'class' => 'btn btn-primary btn-large btn-block')) }}
				
				{{ Html::link('login/index', ucwords(lang('action.login')), array('class' => 'btn btn-block')) }}
			</div>
		</div>
		{{ Form::hidden('_token', csrf_token()) }}
	{{ Form::close() }}
@endif