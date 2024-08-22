{{-- format-ignore-start --}}
<x-email-layout>
# Running story has been completed

**{{ $story->title }}** has been marked as completed.

<x-mail::panel>
{{ $story->description }}
</x-mail::panel>

<x-mail::button :url="route('admin.stories.show', $story)">
Review story &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
