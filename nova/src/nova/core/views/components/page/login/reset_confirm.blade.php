@if ( ! $confirmed)
	{{ Form::open(['url' => "login/reset_confirm/{$user}/{$code}"]) }}
		<div class="form-group">
			{{ Form::password('password', ['placeholder' => lang("Password"), 'class' => 'form-control input-lg']) }}
		</div>

		<div class="form-group">
			{{ Form::password('password_confirm', ['placeholder' => langConcat("Action.confirm Password"), 'class' => 'form-control input-lg']) }}
		</div>

		{{ Form::token() }}
		{{ Form::button(langConcat('Action.confirm Password Action.reset'), ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}
				
		{{ HTML::link('login', ucwords(lang('action.login')), ['class' => 'btn btn-block btn-default']) }}
	{{ Form::close() }}
@endif