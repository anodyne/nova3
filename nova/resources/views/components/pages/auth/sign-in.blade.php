<h1>{{ _m('sign-in') }}</h1>

<div class="alert alert-info">
	<h4 class="alert-heading">Demo Mode</h4>
	<p>You can sign in with one of these demo accounts:</p>

	<dl>
		<dt>System Administrator</dt>
		<dd>Email: admin@example.com</dd>
		<dd>Password: <code>secret</code></dd>

		<dt>General User</dt>
		<dd>Email: user@example.com</dd>
		<dd>Password: <code>secret</code></dd>
	</dl>
</div>

<form role="form" method="POST" action="{{ route('sign-in') }}">
	{{ csrf_field() }}
	<input type="hidden" name="remember" value="true">

	<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
		<label>{{ _m('email-address') }}</label>
		<input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" required autofocus>
		{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
	</div>

	<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
		<label>{{ _m('password') }}</label>
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