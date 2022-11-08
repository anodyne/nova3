<x-notification
    :notification="$notification"
    color="danger"
    icon="remove"
    title="Author removed"
>
    @if (data_get($notification, 'data.post_title') === null)
        <p class="mt-1">Your user account has been removed as an author from a {{ str(data_get($notification, 'data.post_type_name'))->lower() }}.</p>
    @else
        <p class="mt-1">Your user account has been removed as an author from the {{ str(data_get($notification, 'data.post_type_name'))->lower() }} <strong class="font-semibold">{{ data_get($notification, 'data.post_title') }}</strong></p>
    @endif
</x-notification>
