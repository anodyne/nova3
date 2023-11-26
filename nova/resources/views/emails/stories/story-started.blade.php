{{-- format-ignore-start --}}
<x-email-layout>
# New story has been started

The story **{{ $story->title }}** has been started. You can begin posting into the story now.

<x-mail::panel>
{{ $story->description }}
</x-mail::panel>

<x-mail::button :url="route('posts.create')">
Start posting &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
