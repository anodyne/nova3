{{-- format-ignore-start --}}
<x-email-layout>
# Your application has been accepted

{{ $application->decision_message }}

<x-mail::button :url="route('login')">
Sign in now &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
