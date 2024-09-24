@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-primary-500">
        <x-icon name="thumbs-up" size="xl"></x-icon>
    </x-slot>

    You have received a new message as part of one of your conversations from {{ $sender }}.

    <x-slot name="actions">
        <x-button :href="route('admin.messages.index', $discussion_id)" color="neutral">View message</x-button>
    </x-slot>
</x-notification>
