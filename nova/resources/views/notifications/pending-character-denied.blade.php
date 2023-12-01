@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-danger-500">
        <x-icon name="thumbs-down" size="xl"></x-icon>
    </x-slot>

    Your newly created character
    <strong class="font-semibold text-gray-900 dark:text-white">{{ $character_name }}</strong>
    has been denied by the game masters. Please contact them for further information.
</x-notification>
