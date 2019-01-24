<h1 class="header">Verify Your Email Address</h1>

@if (session('resent'))
    <div class="alert alert-success" role="alert">
        A fresh verification link has been sent to your email address.
    </div>
@endif

<p>Before proceeding, please check your email for a verification link. If you did not receive the email, <a href="{{ route('verification.resend') }}">click here to request another</a>.</p>