{{-- format-ignore-start --}}
<x-email-layout>
# {{ $post->title }}

**{{ $post->title }}** has been published in the *{{ $post->story->title }}* story.

<x-mail::button :url="route('posts.show', [$post->story, $post])">
Read {{ str($post->postType->name)->lower() }} &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
