<div class="text-center text-4xl font-semibold mb-1 text-black">{{ _m('sign-in') }}</div>
<div class="text-center text-grey-dark text-sm mb-12">Free access to our dashboard</div>

<form role="form" method="POST" action="{{ route('sign-in') }}">
	@csrf
	<input type="hidden" name="remember" value="true">

	<div>
		<div>
			<label class="block mb-3 text-black text-sm font-medium">Email Address</label>
			<input type="email" id="email" name="email" class="block w-full rounded border p-3 bg-transparent focus:outline-none focus:border-blue" placeholder="name@example.com">
		</div>

		<div class="my-6">
			<div class="flex items-center justify-between mb-3">
				<label class="text-black text-sm font-medium">Password</label>
				<a href="{{ route('password.request') }}" class="no-underline text-grey text-sm hover:underline hover:text-grey-dark" tabindex="-1">{{ _m('auth-forgot-password') }}</a>
			</div>

			<input type="password" name="password" id="password" class="block w-full rounded border p-3 bg-transparent focus:outline-none focus:border-blue" placeholder="Enter your password">
		</div>

		<button type="submit" class="w-full button is-primary is-large">Sign In</button>

		<div class="mt-6 text-grey-dark text-xs text-center">Don't have an account yet? <a href="#" class="no-underline text-blue">Sign up.</a></div>
	</div>
</form>

{{-- <h1>{{ _m('sign-in') }}</h1>

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
</form> --}}
