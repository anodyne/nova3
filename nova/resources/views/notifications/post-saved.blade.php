@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading">
        <x-avatar :src="$user_avatar" size="xs"></x-avatar>
    </x-slot>

    {{ $user_name }} has updated the {{ str($post_type_name)->lower() }}
    <strong class="font-semibold text-gray-900 dark:text-white">{{ $post_title }}.</strong>

    <x-slot name="actions">
        <x-button.outlined :href="route('posts.edit', $post_id)" color="primary">
            Keep writing &rarr;
        </x-button.outlined>
    </x-slot>
</x-notification>
