<div class="flex flex-row min-h-screen">
	<div class="flex flex-col min-h-screen w-1/2 bg-grey-darkest items-center justify-center">
		<h1 class="font-black text-5xl mb-8 text-white w-full text-center">
			USS Nova
			<small class="block font-normal text-blue">To Boldly Go...</small>
		</h1>

		<div class="flex-col alert is-info">
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

		<div class="flex justify-between w-4/5">
			<a href="{{ route('home') }}" class="flex flex-1 items-center justify-center text-grey-dark hover:text-grey-light">
				{{ _m('auth-back-home') }}
			</a>
			<a href="{{ route('password.request') }}" class="flex flex-1 items-center justify-center text-grey-dark hover:text-grey-light">
				{{ _m('auth-forgot-password') }}
			</a>
			<a href="{{ route('join') }}" class="flex flex-1 items-center justify-center text-grey-dark hover:text-grey-light">
				{{ _m('join') }}
			</a>
		</div>
	</div>

	<div class="flex flex-col min-h-screen w-1/2 bg-white text-grey-darker items-center justify-center">
		<div class="w-3/5 mx-auto">
			{!! $content or false !!}
		</div>
	</div>
</div>