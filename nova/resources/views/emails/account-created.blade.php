{{-- format-ignore-start --}}
<x-email-layout>
# User account created

Welcome to the game! A new user account has been created for you. We recommend that you reset the generated password to something you can remember.

<x-mail::panel>
**Password:** {{ $password }}
</x-mail::panel>

<x-mail::button :url="route('login')">Sign in now</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
