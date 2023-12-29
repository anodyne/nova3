@php(extract($notification['data']))

<x-notification :notification="$notification">
    <x-slot name="leading" class="text-success-500">
        <x-icon name="user" size="xl"></x-icon>
    </x-slot>

    Your user account has been added as an author on the {{ str($post_type_name)->lower() }}
    <em class="font-medium">{{ $post_title }}.</em>

    <x-slot name="actions">
        <x-button :href="route('posts.edit', $post_id)" color="primary">Start writing &rarr;</x-button>
    </x-slot>
</x-notification>
