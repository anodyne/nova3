@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-warning-500">
        <x-icon :name="NotificationIcon::UserMinus" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    Your user account has been removed as an author from the {{ str($post_type_name)->lower() }}
    <em>{{ $post_title }}</em>
    {{-- format-ignore-end --}}
</x-notification>
