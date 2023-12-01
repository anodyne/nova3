@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-success-500">
        <x-icon name="thumbs-up" size="xl"></x-icon>
    </x-slot>

    Your newly created character
    <strong class="font-semibold text-gray-900 dark:text-white">{{ $character_name }}</strong>
    has been approved by the game masters and is now available on your account.

    <x-slot name="actions">
        <x-button.filled :href="route('characters.show', $character_id)" color="neutral">View bio</x-button.filled>
    </x-slot>
</x-notification>
