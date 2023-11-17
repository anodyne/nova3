<x-notification
    :notification="$notification"
    color="success"
    :icon="data_get($notification, 'data.post_type_icon')"
    title="{{ data_get($notification, 'data.post_type_name') }} Published"
>
    <p class="mt-1">
        <x-button.text :href="route('posts.show', ['story' => data_get($notification, 'data.story_id', 5), 'post' => data_get($notification, 'data.post_id')])" color="primary" size="none-base">{{ data_get($notification, 'data.post_title') }}</x-button.text> has been published in <x-button.text :href="route('stories.show', data_get($notification, 'data.story_id'))" color="primary">{{ data_get($notification, 'data.story_title') }}</x-button.text>
    </p>
</x-notification>
