<x-notification
    :notification="$notification"
    color="danger"
    icon="trash"
    title="{{ data_get($notification, 'data.post_type_name') }} Draft Discarded"
>
    <p class="mt-1">
        The {{ str(data_get($notification, 'data.post_type_name'))->lower() }} draft of <strong class="font-semibold">{{ data_get($notification, 'data.post_title') }}</strong> has been discarded by {{ data_get($notification, 'data.user') }}
    </p>
</x-notification>
