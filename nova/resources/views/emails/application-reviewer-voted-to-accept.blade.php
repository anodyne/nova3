{{-- format-ignore-start --}}
<x-email-layout>
# Application reviewer voted to accept

**{{ $reviewer->name }}** voted to accept the application for *{{ $application->character->name }}*.

@if (filled($review->comments))
<x-mail::panel>
{{ $review->comments }}
</x-mail::panel>
@endif

<x-mail::button :url="route('admin.applications.show', $application)">
View application &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
