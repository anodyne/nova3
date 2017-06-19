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

				<form role="form" method="POST" action="{{ route('password.email') }}">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
						<label for="email" class="sr-only control-label">{{ _m('email-address') }}</label>
						<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="{{ _m('email-address') }}" required>

						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">
							Send Password Reset Link
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection