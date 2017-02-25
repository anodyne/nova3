{!! Form::open(['route' => 'password.reset']) !!}
	{!! Form::hidden('token', $token) !!}

	<div class="card">
		<div class="card-block">
			<div class="form-group{{ ($errors->has('email')) ? ' has-danger' : '' }}">
				<label class="sr-only">Email Address</label>
				{!! Form::email('email', null, ['class' => 'form-control form-control-danger form-control-lg', 'placeholder' => 'Email Address']) !!}
				{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
			</div>

			<div class="form-group{{ ($errors->has('password')) ? ' has-danger' : '' }}">
				<label class="sr-only">New Password</label>
				{!! Form::password('password', ['class' => 'form-control form-control-danger form-control-lg', 'placeholder' => 'New Password']) !!}
				{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
			</div>

			<div class="form-group{{ ($errors->has('password_confirmation')) ? ' has-danger' : '' }}">
				<label class="sr-only">Confirm New Password</label>
				{!! Form::password('password_confirmation', ['class' => 'form-control form-control-lg', 'placeholder' => 'Confirm New Password']) !!}
				{!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
			</div>

			<button type="submit" class="btn btn-primary btn-lg btn-block">{!! icon('lock') !!} Reset Password</button>
				
			<a href="{{ route('home') }}" class="btn btn-link btn-block" role="button">Cancel</a>
		</div>
	</div>
{!! Form::close() !!}