<x-notification :notification="$notification" color="success" icon="check" title="Pending character approved">
    <p class="mt-1">
        <span class="font-bold">{{ data_get($notification, 'data.character_name') }}</span>
        has been approved.
    </p>
    <div class="mt-3">
        <x-button.outline
            :href="route('characters.show', data_get($notification, 'data.character_id'))"
            color="gray"
            size="sm"
        >
            View bio
        </x-button.outline>
    </div>
</x-notification>
