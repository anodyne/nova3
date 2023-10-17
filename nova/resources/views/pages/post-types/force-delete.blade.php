<x-filament.modal-content icon="trash" title="Force delete post type?">
    <p>
        Are you sure you want to force delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        post type? This action is permanent and cannot be undone.
    </p>

    <p>
        Posts assigned to this post type will still be able to be viewed, but will not have a post type assigned to
        them. You can choose to move posts from this post type to a new one if you wish.
    </p>
</x-filament.modal-content>
