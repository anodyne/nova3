<h1 class="text-center text-4xl font-extrabold mb-8 text-blue-500">Sign In</h1>

<form role="form" method="POST" action="{{ route('sign-in') }}">
	@csrf
	<input type="hidden" name="remember" value="true">

	<div>
		<form-field-email
			label="Email Address"
			name="email"
			placeholder="name@example.com"
		></form-field-email>

		<form-field-password
			name="password"
			placeholder="Enter your password"
			:allow-showing-password="true"
		>
			<template slot="label">
				<label>Password</label>
				<a
					href="{{ route('password.request') }}"
					class="no-underline text-grey-dark hover:underline hover:text-grey-darker"
					tabindex="-1"
				>
					Forgot your password?
				</a>
			</template>
		</form-field-password>

		<button type="submit" class="block w-full p-4 uppercase tracking-wide font-semibold bg-blue-400 text-white rounded hover:bg-blue-500 transition">Sign In</button>

		<div class="mt-6 text-grey-dark text-sm text-center">
			Not a member? <a href="{{ route('join') }}" class="no-underline text-primary hover:text-primary-dark">Apply now.</a>
		</div>
	</div>
</form>