{{-- format-ignore-start --}}
<x-mail::message>
# User account created

A new user account has been created for you. We recommend that you reset the generated password to something you can remember.

<x-mail::panel>
**Password:** {{ $password }}
</x-mail::panel>

<x-mail::button :href="route('login')">Sign in now</x-mail::button>
</x-mail::message>
{{-- format-ignore-end --}}
