<div class="text-center text-4xl font-extrabold mb-1 text-primary-dark">Verify Your Email Address</div>

@if (session('resent'))
	<div class="alert alert-success" role="alert">
		A fresh verification link has been sent to your email address.
	</div>
@endif

Before proceeding, please check your email for a verification link.
If you did not receive the email, <a href="{{ route('verification.resend') }}">click here to request another</a>.