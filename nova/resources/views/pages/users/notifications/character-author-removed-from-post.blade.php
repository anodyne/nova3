<x-notification :notification="$notification" color="danger" icon="remove" title="Character removed as author">
    <p class="mt-1">
        {{ data_get($notification, 'data.character_name') }} has been removed as an author from the
        {{ str(data_get($notification, 'data.post_type_name'))->lower() }}
        <strong class="font-semibold">{{ data_get($notification, 'data.post_title') }}</strong>
    </p>
</x-notification>
