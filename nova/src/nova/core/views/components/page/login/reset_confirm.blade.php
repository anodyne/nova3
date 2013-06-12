@if ( ! $confirmed)
	{{ Form::open(['url' => 'login/reset_confirm/'.$user.'/'.$code]) }}
		<div class="control-group">
			<div class="controls">
				{{ Form::password('password', ['placeholder' => ucwords(lang("password"))]) }}
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				{{ Form::password('password_confirm', ['placeholder' => ucwords(langConcat("action.confirm password"))]) }}
			</div>
		</div>

		{{ Form::token() }}
		{{ Form::button(ucwords(langConcat('action.confirm password action.reset')), ['type' => 'submit', 'class' => 'btn btn-primary btn-large btn-block']) }}
				
		{{ HTML::link('login', ucwords(lang('action.login')), ['class' => 'btn btn-default btn-block']) }}
	{{ Form::close() }}
@endif