@if ( ! $confirmed)
	{{ Form::open(['url' => "login/reset_confirm/{$user}/{$code}"]) }}
		<div class="form-group">
			{{ Form::password('password', ['placeholder' => lang("Password"), 'class' => 'form-control']) }}
		</div>

		<div class="form-group">
			{{ Form::password('password_confirm', ['placeholder' => langConcat("Action.confirm Password"), 'class' => 'form-control']) }}
		</div>

		{{ Form::token() }}
		{{ Form::button(langConcat('Action.confirm Password Action.reset'), ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) }}
				
		{{ HTML::link('login', ucwords(lang('action.login')), ['class' => 'btn btn-default btn-block']) }}
	{{ Form::close() }}
@endif