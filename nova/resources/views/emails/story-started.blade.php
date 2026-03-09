{{-- format-ignore-start --}}
<x-email-layout>
# New story has been started

**{{ $story->title }}** has been started and is now available to post into.

<x-mail::panel>
{{ $story->description }}
</x-mail::panel>

<x-mail::button :url="route('admin.posts.create')">
Start posting <span aria-hidden="true">→</span>
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
