@extends('layouts.auth')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<h1>Reset Password</h1>

				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<form role="form" method="POST" action="{{ route('password.request') }}">
					{{ csrf_field() }}

					<input type="hidden" name="token" value="{{ $token }}">

					<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
						<label for="email" class="sr-only control-label">{{ _m('email-address') }}</label>
						<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ $email or old('email') }}" placeholder="{{ _m('email-address') }}" required autofocus>

						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
						<label for="password" class="sr-only control-label">{{ _m('password-new') }}</label>
						<input id="password" type="password" class="form-control form-control-lg" name="password" placeholder="{{ _m('password-new') }}" required>

						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
						<label for="password-confirm" class="sr-only control-label">{{ _m('password-new-confirm') }}</label>
						<input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="{{ _m('password-new-confirm') }}" required>

						@if ($errors->has('password_confirmation'))
							<span class="help-block">
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">
							Reset Password
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection