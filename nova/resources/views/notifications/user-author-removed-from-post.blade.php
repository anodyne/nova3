@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-danger-500">
        <x-icon name="user" size="xl"></x-icon>
    </x-slot>

    Your user account has been removed as an author from the {{ str($post_type_name)->lower() }}
    <em class="font-medium">{{ $post_title }}.</em>
</x-notification>
