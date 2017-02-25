@if (session()->has('password_reset_required'))
	{!! alert('warning', session()->get('password_reset_required'), "Password Reset Required") !!}
@endif

{!! Form::open(['route' => 'password.email']) !!}
	<div class="card">
		<div class="card-block">
			<div class="form-group">
				<label class="sr-only">Email Address</label>
				{!! Form::email('email', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'Email Address']) !!}
			</div>

			<button type="submit" class="btn btn-primary btn-lg btn-block">{!! icon('paper-plane') !!} Send Password Reset Link</button>

			<a href="{{ route('home') }}" class="btn btn-link btn-block" role="button">Cancel</a>
		{!! Form::close() !!}
	</div>
</div>