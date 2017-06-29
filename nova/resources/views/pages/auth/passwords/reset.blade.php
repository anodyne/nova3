@extends('layouts.auth')

@section('content')
	<h1>{{ _m('auth-reset-password') }}</h1>

	<form role="form" method="POST" action="{{ route('password.request') }}">
		{{ csrf_field() }}
		<input type="hidden" name="token" value="{{ $token }}">

		<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
			<label for="email" class="form-control-label">{{ _m('email-address') }}</label>
			
			<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ $email or old('email') }}" required autofocus>

			{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
		</div>

		<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
			<label for="password" class="form-control-label">{{ _m('password-new') }}</label>
			
			<input id="password" type="password" class="form-control form-control-lg" name="password" required>

			{!! $errors->first('password', '<p class="form-control-feedback">:message</p>') !!}
		</div>

		<div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
			<label for="password-confirm" class="form-control-label">{{ _m('password-new-confirm') }}</label>
			
			<input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required>

			{!! $errors->first('password_confirmation', '<p class="form-control-feedback">:message</p>') !!}
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">
				{{ _m('auth-reset-password') }}
			</button>

			<a href="{{ route('home') }}" class="btn btn-link btn-block">{{ _m('cancel') }}</a>
		</div>
	</form>
@endsection