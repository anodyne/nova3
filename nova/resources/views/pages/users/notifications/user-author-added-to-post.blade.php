<x-notification :notification="$notification" color="success" icon="add" title="User account added as author">
    <p class="mt-1">
        Your user account has been added as an author on the
        {{ str(data_get($notification, 'data.post_type_name'))->lower() }}
        <strong class="font-semibold">{{ data_get($notification, 'data.post_title') }}</strong>
    </p>
    <p class="mt-4">
        <x-button.filled :href="route('posts.edit', data_get($notification, 'data.post_id'))" color="neutral">
            Start writing
        </x-button.filled>
    </p>
</x-notification>
