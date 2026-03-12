@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.applications.show', $application_id)">
    <x-slot name="leading" class="text-danger-500">
        <x-icon :name="NotificationIcon::UserX" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $reviewer_name }}</strong> has voted to deny the application for
    <strong>{{ $character_name }}</strong>
    {{-- format-ignore-end --}}
</x-notification>
