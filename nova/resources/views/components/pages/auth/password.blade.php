{!! Form::open(['route' => 'password.email.send']) !!}
	<div class="form-group">
		{!! Form::email('email', null, ['class' => 'form-control input-lg', 'placeholder' => 'Email Address']) !!}
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-lg btn-block">{!! icon('send') !!} Send Password Reset Link</button>
		
		<a href="{{ route('home') }}" class="btn btn-link btn-lg btn-block">Cancel</a>
	</div>
{!! Form::close() !!}