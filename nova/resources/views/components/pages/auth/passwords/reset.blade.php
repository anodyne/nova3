<div class="text-center text-4xl font-extrabold mb-12 text-primary-dark">{{ _m('auth-reset-password') }}</div>

<form role="form" method="POST" action="{{ route('password.request') }}">
	@csrf
	<input type="hidden" name="token" value="{{ $token }}">

	<div class="mb-6">
		<label class="block mb-2 text-grey-darker uppercase tracking-wide text-sm font-medium">{{ _m('email-address') }}</label>
		<input type="email" id="email" name="email" class="block w-full rounded border p-3 bg-transparent focus:outline-none focus:border-blue" placeholder="name@example.com" value="{{ $email ?? old('email') }}" required autofocus>
	</div>

	<div class="mb-6">
		<label class="block mb-2 text-grey-darker uppercase tracking-wide text-sm font-medium">{{ _m('password-new') }}</label>
		<input type="password" id="password" name="password" class="block w-full rounded border p-3 bg-transparent focus:outline-none focus:border-blue" required>
	</div>

	<div class="mb-6">
		<label class="block mb-2 text-grey-darker uppercase tracking-wide text-sm font-medium">{{ _m('password-new-confirm') }}</label>
		<input type="password" id="password-confirm" name="password_confirmation" class="block w-full rounded border p-3 bg-transparent focus:outline-none focus:border-blue" required>
	</div>

	<button type="submit" class="block w-full p-4 uppercase tracking-wide font-semibold bg-primary text-white rounded hover:bg-primary-dark transition">
		{{ _m('auth-reset-password') }}
	</button>

	<a href="{{ route('home') }}" class="block w-full p-4 uppercase tracking-wide font-semibold bg-grey-light text-grey-darker rounded hover:bg-grey hover:text-grey-darker transition mt-6 text-center">
		{{ _m('cancel') }}
	</a>

	<div class="mt-6 text-grey-dark text-sm text-center">
		Don't have an account yet? <a href="{{ route('home') }}" class="no-underline text-blue">Cancel</a>
	</div>
</form>