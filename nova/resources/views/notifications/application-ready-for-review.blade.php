@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.applications.show', $application_id)">
    <x-slot name="leading" class="text-info-500">
        <x-icon :name="NotificationIcon::UserProfile2" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    An application for <strong>{{ $character_name }}</strong> is ready for review
    {{-- format-ignore-end --}}
</x-notification>
