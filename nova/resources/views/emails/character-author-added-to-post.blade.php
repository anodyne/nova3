{{-- format-ignore-start --}}
<x-email-layout>
# Character author added to post

**{{ $character->name }}** has been added as an author on the {{ str($post->postType->name)->lower() }} *{{ $post->title }}*.

<x-mail::button :url="route('admin.posts.edit', $post)">
Start writing &rarr;
</x-mail::button>
</x-email-layout>
{{-- format-ignore-end --}}
