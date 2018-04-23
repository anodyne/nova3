<h1>{{ _m('sign-in') }}</h1>

<form role="form" method="POST" action="{{ route('sign-in') }}">
	{{ csrf_field() }}
	<input type="hidden" name="remember" value="true">

	<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
		<label class="input-label">{{ _m('email-address') }}</label>
		<input id="email" type="email" class="input bg-grey-lighter border-2 border-grey-lighter rounded p-2" name="email" value="{{ old('email') }}" required autofocus>
		{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
	</div>

	<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
		<label class="flex items-center justify-between input-label">
			<span>{{ _m('password') }}</span>
			<span>
					<a href="{{ route('password.request') }}" class="uppercase text-sm">{{ _m('auth-forgot-password') }}</a>
			</span>
		</label>
		<input id="password" type="password" class="input bg-grey-lighter border-2 border-grey-lighter rounded p-2" name="password" required>
		{!! $errors->first('password', '<p class="form-control-feedback">:message</p>') !!}
	</div>

	<div class="form-group">
		<button type="submit" class="button is-primary is-block">{{ _m('sign-in') }}</button>
	</div>
</form>