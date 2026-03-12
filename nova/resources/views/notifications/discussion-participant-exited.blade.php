@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.messages.index', $discussion_id)">
    <x-slot name="leading" class="text-danger-500">
        <x-icon :name="NotificationIcon::Logout" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $user_name }}</strong> has left the <em>{{ $discussion_subject }}</em> discussion
    {{-- format-ignore-end --}}
</x-notification>
