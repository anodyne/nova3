@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-warning-500">
        <x-icon name="user" size="xl"></x-icon>
    </x-slot>

    <strong class="font-semibold text-gray-900 dark:text-white">{{ $character_name }}</strong>
    has been created by {{ $creator_name }} and requires approval before it can be activated.

    <x-slot name="actions">
        <x-button :href="route('characters.show', $character_id)" color="primary">Review &rarr;</x-button>
    </x-slot>
</x-notification>
