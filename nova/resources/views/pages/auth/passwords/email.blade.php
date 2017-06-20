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

				<form role="form" method="POST" action="{{ route('password.email') }}">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
						<label for="email" class="form-control-label sr-only">{{ _m('email-address') }}</label>
						
						<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" placeholder="{{ _m('email-address') }}" required>

						{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">
							{{ _m('auth-send-reset-link') }}
						</button>

						<a href="{{ route('home') }}" class="btn btn-link btn-block">{{ _m('cancel') }}</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection