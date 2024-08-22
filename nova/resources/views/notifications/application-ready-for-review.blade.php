@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-warning-500">
        <x-icon name="progress-check" size="xl"></x-icon>
    </x-slot>

    An application for
    <strong class="font-semibold text-gray-900 dark:text-white">{{ $character_name }}</strong>
    is ready to be reviewed.

    <x-slot name="actions">
        <x-button :href="route('admin.applications.show', $application_id)" color="primary">
            Start reviewing &rarr;
        </x-button>
    </x-slot>
</x-notification>
