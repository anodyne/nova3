{{-- format-ignore-start --}}
<x-email-layout>
# Draft post has been discarded

{{ $user->name }} has discarded the {{ str($post->postType->name)->lower() }} draft of **{{ $post->title }}**.
</x-email-layout>
{{-- format-ignore-end --}}
