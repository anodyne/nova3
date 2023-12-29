@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-primary-500">
        <x-icon name="megaphone" size="xl"></x-icon>
    </x-slot>

    <strong class="font-semibold text-gray-900 dark:text-white">{{ $announcement_title }}</strong>
    announcement has been published.

    <x-slot name="actions">
        <x-button :href="route('stories.show', $announcement_id)" color="neutral">Read &rarr;</x-button>
    </x-slot>
</x-notification>
