@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-danger-500">
        <x-icon name="exit" size="xl"></x-icon>
    </x-slot>

    {{ $user_name }} has left the {{ $discussion_subject }} discussion.

    <x-slot name="actions">
        <x-button :href="route('admin.messages.index', $discussion_id)" color="neutral">View message</x-button>
    </x-slot>
</x-notification>
