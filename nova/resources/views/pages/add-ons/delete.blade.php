<x-filament.modal-content :$action title="Delete add-on?">
    <p>
        Are you sure you want to delete the
        <strong>{{ $record->name }}</strong>
        {{ $record->type->value }}?
    </p>

    <p>
        The files for the add-on will remain on the server, but you will no longer be able to use the add-on on your
        site.
    </p>
</x-filament.modal-content>
