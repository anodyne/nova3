@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-primary-500">
        <x-icon name="user" size="xl"></x-icon>
    </x-slot>

    Your user account has been created. Welcome to the game! If you have not already changed your generated password, we
    recommend that you do so before doing anything else.
</x-notification>
