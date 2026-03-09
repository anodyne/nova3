@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.posts.edit', $post_id)">
    <x-slot name="leading" class="text-success-500">
        <x-icon :name="NotificationIcon::UserPlus" size="lg" />
    </x-slot>

    {{-- format-ignore-start --}}
    Your user account has been added as an author on the {{ str($post_type_name)->lower() }}
    <em>{{ $post_title }}</em>
    {{-- format-ignore-end --}}
</x-notification>
