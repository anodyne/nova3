@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-primary-500">
        <x-icon :name="NotificationIcon::UserProfile" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    Your user account has been created. Welcome to the game! If you have not
    already changed your generated password, we recommend that you do so before
    doing anything else.
    {{-- format-ignore-end --}}
</x-notification>
