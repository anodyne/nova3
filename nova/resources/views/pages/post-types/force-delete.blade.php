<x-filament.modal-content :$action title="Force delete post type?">
    <x-text variant="strong">
        Are you sure you want to force delete the
        <strong>{{ $record->name }}</strong>
        post type? This action is permanent and cannot be undone.
    </x-text>

    <x-text variant="strong">
        Posts assigned to this post type will still be able to be viewed, but will not have a post type assigned to
        them. You can choose to move posts from this post type to a new one if you wish.
    </x-text>
</x-filament.modal-content>
