<x-filament.modal-content icon="trash" title="Delete rank item?">
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name?->name }}</strong>
        rank item from the
        <em>{{ $record->group?->name }}</em>
        rank group? You won't be able to recover it.
    </p>

    @if ($record->characters->count() > 0)
        <p>Any character with this rank will need to have a new rank assigned to them.</p>
    @endif
</x-filament.modal-content>
