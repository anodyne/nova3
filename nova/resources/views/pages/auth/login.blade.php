@extends('layouts.auth')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-xl-4 offset-md-3 offset-xl-4">
				<h1>{{ _m('sign-in') }}</h1>

				<form role="form" method="POST" action="{{ route('login') }}">
					{{ csrf_field() }}
					<input type="hidden" name="remember" value="true">

					<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
						<label class="form-control-label">{{ _m('email-address') }}</label>

						<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" required autofocus>
						
						{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
					</div>

					<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
						<label class="form-control-label">{{ _m('password') }}</label>

						<input id="password" type="password" class="form-control form-control-lg" name="password" required>

						{!! $errors->first('password', '<p class="form-control-feedback">:message</p>') !!}
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col">
								<button type="submit" class="btn btn-lg btn-primary btn-block">{{ _m('sign-in') }}</button>
							</div>
						</div>
					</div>

					<div class="form-group">
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
						<a href="{{ route('password.request') }}" class="btn btn-link btn-block">
							{{ _m('auth-forgot-password') }}
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection