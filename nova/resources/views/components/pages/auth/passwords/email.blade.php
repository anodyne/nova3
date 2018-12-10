<div class="text-center text-4xl font-extrabold mb-12 text-primary-dark">{{ _m('auth-forgot-password') }}</div>

<form role="form" method="POST" action="{{ route('password.email') }}">
	@csrf

	<div class="mb-6">
		<label class="block mb-2 text-grey-darker uppercase tracking-wide text-sm font-medium">{{ _m('email-address') }}</label>
		<input type="email" id="email" name="email" class="block w-full rounded border p-3 bg-transparent focus:outline-none focus:border-blue" placeholder="name@example.com" value="{{ old('email') }}" autofocus required>
	</div>

	<button type="submit" class="block w-full p-4 uppercase tracking-wide font-semibold bg-primary text-white rounded hover:bg-primary-dark transition">
		{{ _m('auth-send-reset-link') }}
	</button>

	<div class="mt-6 text-grey-dark text-sm text-center">
		Don't have an account yet? <a href="{{ route('home') }}" class="no-underline text-blue">Cancel</a>
	</div>
</form>
