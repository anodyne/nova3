{{-- format-ignore-start --}}
<x-email-layout>
# {{ $post->title }} has been updated

{{ $user->name }} has updated the {{ str($post->postType->name)->lower() }} **{{ $post->title }}**.

<x-mail::button :url="route('admin.posts.edit', $post)">
Keep writing <span aria-hidden="true">→</span>
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
