@php
    extract($notification['data']);

    $postTypeIcon = Tabler::tryFrom($post_type_icon);
@endphp

<x-notification
    :notification="$notification"
    :href="route('admin.posts.show', ['story' => $story_id, 'post' => $post_id])"
>
    <x-slot name="leading" style="color:{{ $post_type_color }}">
        <x-icon :name="$postTypeIcon" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $post_title }}</strong> has been published in <em>{{ $story_title }}</em>
    {{-- format-ignore-end --}}
</x-notification>
