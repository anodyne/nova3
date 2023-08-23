<x-filament.modal-content icon="trash" title="Delete post type?">
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        post type? {{ $record->can_be_deleted ? "You won't be able to recover it." : null }}
    </p>

    <p>Users will no longer be able to create story posts with this post type.</p>
</x-filament.modal-content>
