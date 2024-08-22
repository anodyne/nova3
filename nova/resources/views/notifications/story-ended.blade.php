@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-success-500">
        <x-icon name="books" size="xl"></x-icon>
    </x-slot>

    <strong class="font-semibold text-gray-900 dark:text-white">{{ $story_title }}</strong>
    has been marked as completed.

    <x-slot name="actions">
        <x-button :href="route('admin.stories.show', $story_id)" color="neutral">Review story</x-button>
    </x-slot>
</x-notification>
