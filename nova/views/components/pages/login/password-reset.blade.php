<div class="title">Reset Password</div>

{!! Form::open(['route' => 'password.reset']) !!}
	{!! Form::hidden('token', $token) !!}

	<div class="form-group">
		{!! Form::email('email', false, ['class' => 'form-control input-lg', 'placeholder' => 'Email Address']) !!}
	</div>

	<div class="form-group">
		{!! Form::password('password', ['class' => 'form-control input-lg', 'placeholder' => 'New Password']) !!}
	</div>

	<div class="form-group">
		{!! Form::password('password_confirm', ['class' => 'form-control input-lg', 'placeholder' => 'Confirm New Password']) !!}
	</div>

	<div class="form-group">
		{!! Form::button('Reset Password', ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) !!}
		<a href="{{ route('home') }}" class="btn btn-link btn-lg btn-block">Cancel</a>
	</div>
{!! Form::close() !!}