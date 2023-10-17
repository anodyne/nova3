<x-filament.modal-content icon="trash" title="Delete post type?">
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        post type? Users will no longer be able to create posts with this post type.
    </p>

    @if ($record->posts_count === 0)
        <p>This action is permanent and cannot be undone.</p>
    @else
        <p>
            Posts assigned to this post type will still be able to be viewed. You can choose to move posts from this
            post type to a new one if you wish.
        </p>
    @endif
</x-filament.modal-content>
