@component('mail::message')
You are receiving this email because an admin has forced a password reset for your account. You will not be able to sign in until you've reset your password.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent