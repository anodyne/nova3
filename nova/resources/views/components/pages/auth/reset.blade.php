{!! Form::open(['route' => 'password.reset']) !!}
	{!! Form::hidden('token', $token) !!}

	<div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
		{!! Form::email('email', null, ['class' => 'form-control input-lg', 'placeholder' => 'Email Address']) !!}
		{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="form-group{{ ($errors->has('password')) ? ' has-error' : '' }}">
		{!! Form::password('password', ['class' => 'form-control input-lg', 'placeholder' => 'New Password']) !!}
		{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="form-group{{ ($errors->has('password_confirmation')) ? ' has-error' : '' }}">
		{!! Form::password('password_confirmation', ['class' => 'form-control input-lg', 'placeholder' => 'Confirm New Password']) !!}
		{!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-lg btn-block">{!! icon('lock') !!} Reset Password</button>
		
		<a href="{{ route('home') }}" class="btn btn-link btn-lg btn-block">Cancel</a>
	</div>
{!! Form::close() !!}