<x-notification
    :notification="$notification"
    color="warning"
    :icon="data_get($notification, 'data.post_type_icon')"
    title="{{ data_get($notification, 'data.post_type_name') }} Saved"
>
    <p class="mt-1">
        {{ data_get($notification, 'data.author_name') }} has updated the {{ str(data_get($notification, 'data.post_type_name'))->lower() }} <x-link :href="route('posts.create', data_get($notification, 'data.post_id'))" color="primary-text" size="none-base">{{ data_get($notification, 'data.post_title') }}</x-link>
    </p>
</x-notification>