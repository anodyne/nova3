<x-notification :notification="$notification" color="success" icon="books" title="New story started">
    <p class="mt-1">
        <x-button.text :href="route('stories.show', data_get($notification, 'data.story_id'))" color="primary">
            {{ data_get($notification, 'data.story_title') }}
        </x-button.text>
        has been started and can be posted into now.
    </p>
</x-notification>
