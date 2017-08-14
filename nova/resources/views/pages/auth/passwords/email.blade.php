@extends('layouts.auth')

@section('content')
	<h1>{{ _m('auth-reset-password') }}</h1>

	<form role="form" method="POST" action="{{ route('password.email') }}">
		{{ csrf_field() }}

		<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
			<label for="email" class="form-control-label">{{ _m('email-address') }}</label>
			<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" autofocus required>
			{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-lg btn-primary btn-block">
				{{ _m('auth-send-reset-link') }}
			</button>
			<a href="{{ route('home') }}" class="btn btn-link btn-block">{{ _m('cancel') }}</a>
		</div>
	</form>
@endsection