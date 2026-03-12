@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-danger-500">
        <x-icon :name="NotificationIcon::UserDelete" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $user_name }}</strong> has deleted their account. Personally
    identifiable information has been removed and any characters, story posts,
    announcements, and personal conversations have been updated to reflect the
    deletion. No further action is required on your part.
    {{-- format-ignore-end --}}
</x-notification>
