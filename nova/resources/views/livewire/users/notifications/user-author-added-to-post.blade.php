<x-notification :notification="$notification" color="success" icon="add" title="Author added">
    @if (data_get($notification, 'data.post_title') === null)
        <p class="mt-1">
            Your user account has been added as an author on a
            {{ str(data_get($notification, 'data.post_type_name'))->lower() }}.
        </p>
        <p class="mt-2">
            <x-button.filled :href="route('posts.create', data_get($notification, 'data.post_id'))" color="neutral">
                Start writing
            </x-button.filled>
        </p>
    @else
        <p class="mt-1">
            Your user account has been added as an author on the
            {{ str(data_get($notification, 'data.post_type_name'))->lower() }}
            <x-button.text :href="route('posts.create', data_get($notification, 'data.post_id'))" color="primary">
                {{ data_get($notification, 'data.post_title') }}
            </x-button.text>
        </p>
    @endif
</x-notification>
