<div class="page-header">
	<h1>Log In</h1>
</div>

{!! Form::open(['route' => 'login.do']) !!}
	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		{!! Form::email('email', false, ['class' => 'form-control input-lg', 'placeholder' => 'Email Address']) !!}
		{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		{!! Form::password('password', ['class' => 'form-control input-lg', 'placeholder' => 'Password']) !!}
		{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="form-group">
		{!! Form::button('Log In', ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) !!}
		<a href="{{ route('password.email') }}" class="btn btn-link btn-lg btn-block">Forgot Your Password?</a>
		<a href="#" class="btn btn-link btn-lg btn-block disabled">Not a Member? Join Today!</a>
		<a href="{{ route('home') }}" class="btn btn-link btn-lg btn-block">Back Home</a>
	</div>
{!! Form::close() !!}