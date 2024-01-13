<x-filament.modal-content icon="trash" title="Delete rank group?">
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        rank group? You won’t be able to recover it.
    </p>

    @if ($record->ranks->count() > 0)
        <p>
            This will also delete all ranks within the group and any characters with those ranks will need to have new
            ranks assigned to them.
        </p>
    @endif
</x-filament.modal-content>
