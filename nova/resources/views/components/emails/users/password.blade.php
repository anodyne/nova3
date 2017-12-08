@component('mail::message')
You are receiving this email because a password has been generated for your account.

Your password is {{ $password }}. Please reset your password when you sign in to ensure your password is private.

Thanks, <br>
{{ config('app.name') }}
@endcomponent