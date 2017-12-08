@component('mail::message')
You are receiving this email because an admin has created an account for you. For security and privacy reasons, you will have to reset your password before you can sign in.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

Thanks, <br>
{{ config('app.name') }}
@endcomponent