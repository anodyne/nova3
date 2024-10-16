@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" style="color:{{ $post_type_color }}">
        <x-icon :name="$post_type_icon" size="xl"></x-icon>
    </x-slot>

    <strong class="font-semibold text-gray-900 dark:text-white">{{ $post_title }}</strong>
    has been published in the
    <em class="font-medium">{{ $story_title }}</em>
    story.

    <x-slot name="actions">
        <x-button :href="route('admin.posts.create')" color="primary">Read &rarr;</x-button>
        <x-button :href="route('admin.stories.show', $story_id)" color="neutral">Go to story</x-button>
    </x-slot>
</x-notification>
