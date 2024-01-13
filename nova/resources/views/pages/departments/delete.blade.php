<x-filament.modal-content icon="trash" title="Delete department?">
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        department? You won’t be able to recover it.
    </p>

    <p>
        All positions assigned to this department will be removed. Any characters assigned to a position that is removed
        will need to be re-assigned to a new position.
    </p>
</x-filament.modal-content>
