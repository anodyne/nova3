@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.messages.index', $discussion_id)">
    <x-slot name="leading" class="text-gray-500">
        <x-icon :name="NotificationIcon::Inbox" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    You have received a new message from <strong>{{ $sender }}</strong>
    {{-- format-ignore-end --}}
</x-notification>
