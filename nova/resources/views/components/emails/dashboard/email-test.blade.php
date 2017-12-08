@component('mail::message')
This test email was sent on {{ $date }} to verify that all email settings are working as expected.

Thanks, <br>
{{ config('app.name') }}
@endcomponent