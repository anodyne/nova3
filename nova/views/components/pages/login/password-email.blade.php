<div class="title">Reset Password</div>

{!! Form::open(['route' => 'password.email.send']) !!}
	<div class="form-group">
		{!! Form::email('email', false, ['class' => 'form-control input-lg', 'placeholder' => 'Email Address']) !!}
	</div>

	<div class="form-group">
		{!! Form::button('Send Password Reset Link', ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) !!}
		<a href="{{ route('home') }}" class="btn btn-link btn-lg btn-block">Cancel</a>
	</div>
{!! Form::close() !!}