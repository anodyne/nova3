{{-- format-ignore-start --}}
<x-email-layout>
# Your application has been accepted

{{ $application->decision_message }}

<x-mail::button :url="route('login')">
Sign in now
<span aria-hidden="true">→</span>
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
