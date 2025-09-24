<x-filament.modal-content :$action title="Delete post type?">
    <x-text variant="strong">
        Are you sure you want to delete the
        <strong>{{ $record->name }}</strong>
        post type? Users will no longer be able to create posts with this post type.
    </x-text>

    @if ($record->posts_count === 0)
        <x-text variant="strong">This action is permanent and cannot be undone.</x-text>
    @else
        <x-text variant="strong">
            Posts assigned to this post type will still be able to be viewed. You can choose to move posts from this
            post type to a new one if you wish.
        </x-text>
    @endif
</x-filament.modal-content>
