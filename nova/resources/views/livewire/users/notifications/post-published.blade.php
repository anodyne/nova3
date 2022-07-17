<x-notification
    :notification="$notification"
    color="success"
    :icon="data_get($notification, 'data.post_type_icon')"
    title="{{ data_get($notification, 'data.post_type_name') }} Published"
>
    <p class="mt-1">
        <x-link :href="route('posts.show', ['story' => data_get($notification, 'data.story_id', 5), 'post' => data_get($notification, 'data.post_id')])" color="primary-text" size="none-base">{{ data_get($notification, 'data.post_title') }}</x-link> has been published in <x-link :href="route('stories.show', data_get($notification, 'data.story_id'))" color="primary-text" size="none-base">{{ data_get($notification, 'data.story_title') }}</x-link>
    </p>
</x-notification>
