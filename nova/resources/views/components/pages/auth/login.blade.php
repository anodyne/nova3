<div class="card">
	<div class="card-block">
		{!! Form::open(['route' => 'login.login']) !!}
			<div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
				<label class="sr-only">Email Address</label>
				{!! Form::email('email', null, ['class' => 'form-control form-control-danger form-control-lg', 'placeholder' => 'Email Address']) !!}
				{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
			</div>

			<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
				<label class="sr-only">Password</label>
				{!! Form::password('password', ['class' => 'form-control form-control-danger form-control-lg', 'placeholder' => 'Password']) !!}
				{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
			</div>

			<button type="submit" class="btn btn-primary btn-lg btn-block">{!! icon('sign-in') !!} Log In</button>
		{!! Form::close() !!}
	</div>

	<div class="card-footer">
		<div class="row">
			<div class="col-md-6">
				<a href="{{ route('password.email.show') }}" class="btn btn-link btn-block">Forgot Your Password?</a>
			</div>
			<div class="col-md-6">
				<a href="{{ route('home') }}" class="btn btn-link btn-block">Back Home</a>
			</div>
		</div>
	</div>
</div>