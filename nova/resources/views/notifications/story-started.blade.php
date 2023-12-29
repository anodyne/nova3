@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-success-500">
        <x-icon name="books" size="xl"></x-icon>
    </x-slot>

    <strong class="font-semibold text-gray-900 dark:text-white">{{ $story_title }}</strong>
    has been started and is now available to post into.

    <x-slot name="actions">
        <x-button :href="route('posts.create')" color="primary">Start writing &rarr;</x-button>
        <x-button :href="route('stories.show', $story_id)" color="neutral">Go to story</x-button>
    </x-slot>
</x-notification>
