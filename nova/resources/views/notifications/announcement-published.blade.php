@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.announcements.show', $announcement_id)">
    <x-slot name="leading" class="text-primary-500">
        <x-icon :name="NotificationIcon::Megaphone" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $announcement_title }}</strong> announcement has been published
    {{-- format-ignore-end --}}
</x-notification>
