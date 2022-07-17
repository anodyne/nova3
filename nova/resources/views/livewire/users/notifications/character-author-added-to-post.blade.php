<x-notification
    :notification="$notification"
    color="success"
    icon="add"
    title="Author added"
>
    @if (data_get($notification, 'data.post_title') === null)
        <p class="mt-1">Your {{ str('character')->plural(data_get($notification, 'data.character_count')) }} {{ data_get($notification, 'data.character_names') }} @choice('has|have', data_get($notification, 'data.character_count')) been added as @choice('an author|authors', data_get($notification, 'data.character_count')) on a {{ str(data_get($notification, 'data.post_type_name'))->lower() }}.</p>
        <p class="mt-2">
            <x-link :href="route('posts.create', data_get($notification, 'data.post_id'))" size="xs" color="white">
                Start writing
            </x-link>
        </p>
    @else
        <p class="mt-1">Your {{ str('character')->plural(data_get($notification, 'data.character_count')) }} {{ data_get($notification, 'data.character_names') }} @choice('has|have', data_get($notification, 'data.character_count')) been added as @choice('an author|authors', data_get($notification, 'data.character_count')) on the {{ str(data_get($notification, 'data.post_type_name'))->lower() }} <x-link :href="route('posts.create', data_get($notification, 'data.post_id'))" color="primary-text" size="none-base">{{ data_get($notification, 'data.post_title') }}</x-link></p>
    @endif
</x-notification>
