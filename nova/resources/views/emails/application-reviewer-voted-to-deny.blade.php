{{-- format-ignore-start --}}
<x-email-layout>
# Application reviewer voted to deny

**{{ $reviewer->name }}** voted to deny the application for *{{ $application->character->name }}*.

@if (filled($review->comments))
<x-mail::panel>
{{ $review->comments }}
</x-mail::panel>
@endif

<x-mail::button :url="route('admin.applications.show', $application)">
View application <span aria-hidden="true">→</span>
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
