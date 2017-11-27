@component('mail::message')
You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => url(config('app.url').route('password.reset', $token, false))])
Reset Password
@endcomponent

If you did not request a password reset, no further action is required.

Thanks, <br>
{{ config('app.name') }}
@endcomponent