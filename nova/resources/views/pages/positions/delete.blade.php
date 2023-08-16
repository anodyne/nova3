<x-filament.modal-content icon="trash" title="Delete position?">
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        position from the {{ $record->department?->name }} department? You won't be able to recover it.
    </p>

    <p>Any characters assigned to this position will need to be re-assigned to another position.</p>
</x-filament.modal-content>
