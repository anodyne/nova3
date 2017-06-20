@extends('layouts.auth')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-xl-4 offset-md-3 offset-xl-4">
				<h1>{{ _m('auth-reset-password') }}</h1>

				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<form role="form" method="POST" action="{{ route('password.request') }}">
					{{ csrf_field() }}
					<input type="hidden" name="token" value="{{ $token }}">

					<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
						<label for="email" class="form-control-label sr-only">{{ _m('email-address') }}</label>
						
						<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ $email or old('email') }}" placeholder="{{ _m('email-address') }}" required autofocus>

						{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
					</div>

					<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
						<label for="password" class="form-control-label sr-only">{{ _m('password-new') }}</label>
						
						<input id="password" type="password" class="form-control form-control-lg" name="password" placeholder="{{ _m('password-new') }}" required>

						{!! $errors->first('password', '<p class="form-control-feedback">:message</p>') !!}
					</div>

					<div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
						<label for="password-confirm" class="form-control-label sr-only">{{ _m('password-new-confirm') }}</label>
						
						<input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="{{ _m('password-new-confirm') }}" required>

						{!! $errors->first('password_confirmation', '<p class="form-control-feedback">:message</p>') !!}
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">
							{{ _m('auth-reset-password') }}
						</button>

						<a href="{{ route('home') }}" class="btn btn-link btn-block">{{ _m('cancel') }}</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection