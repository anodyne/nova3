@php(extract($notification['data']))

<x-notification :notification="$notification" :href="route('admin.posts.edit', $post_id)">
    <x-slot name="leading">
        <x-avatar :src="$user_avatar" size="sm" />
    </x-slot>

    {{-- format-ignore-start --}}
    <strong>{{ $user_name }}</strong> has updated the
    {{ str($post_type_name)->lower() }} <em>{{ $post_title }}</em>
    {{-- format-ignore-end --}}
</x-notification>
