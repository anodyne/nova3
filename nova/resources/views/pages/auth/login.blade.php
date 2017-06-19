@extends('layouts.auth')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-xl-4 offset-md-3 offset-xl-4">
				<h1>{{ _m('sign-in') }}</h1>

				<form role="form" method="POST" action="{{ route('login') }}">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
						<label for="email" class="sr-only control-label">{{ _m('email-address') }}</label>
						<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="{{ _m('email-address') }}" required autofocus>

						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
						<label for="password" class="sr-only control-label">{{ _m('password') }}</label>
						<input id="password" type="password" class="form-control form-control-lg" name="password" placeholder="{{ _m('password') }}" required>

						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>

					<div class="form-group">
						<div class="row mb-4">
							<div class="col">
								<button type="submit" class="btn btn-primary btn-block">{{ _m('sign-in') }}</button>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<a href="{{ route('join') }}" class="btn btn-secondary btn-block">{{ _m('join') }}</a>
							</div>
							<div class="col">
								<a href="{{ route('home') }}" class="btn btn-secondary btn-block">{{ _m('auth-back-home') }}</a>
							</div>
						</div>
					</div>

					<div class="form-group">
						<a href="{{ route('password.request') }}">
							{{ _m('auth-forgot-password') }}
						</a>

						<input type="hidden" name="remember" value="true">
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection