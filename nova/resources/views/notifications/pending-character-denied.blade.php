@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-danger-500">
        <x-icon :name="NotificationIcon::ThumbsDown" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    Your newly created character <strong>{{ $character_name }}</strong>
    has been denied by the game masters. Please contact them for further information.
    {{-- format-ignore-end --}}
</x-notification>
