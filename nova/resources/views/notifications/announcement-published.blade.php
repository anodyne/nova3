@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-primary-500">
        <x-icon name="megaphone" size="xl"></x-icon>
    </x-slot>

    <strong class="font-semibold text-gray-900 dark:text-white">{{ $announcement_title }}</strong>
    announcement has been published in the
    <em>{{ $announcement_category }}</em>
    category.

    <x-slot name="actions">
        <x-button :href="route('admin.announcements.show', $announcement_id)">Read &rarr;</x-button>
    </x-slot>
</x-notification>
