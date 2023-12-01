{{-- format-ignore-start --}}
<x-email-layout>
# User account added to post

Your user account has been added as an author on the {{ str($post->postType->name)->lower() }} *{{ $post->title }}*.

<x-mail::button :url="route('posts.edit', $post)">
Start writing &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
