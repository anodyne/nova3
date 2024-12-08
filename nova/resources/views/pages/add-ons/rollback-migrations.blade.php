<x-filament.modal-content icon="bolt-off" title="Delete add-on?">
    <p>
        Are you sure you want to rollback the database migrations for the
        <strong class="font-semibold">{{ $record->name }}</strong>
        {{ $record->type->value }}?
    </p>

    <p>If the add-on author This will remove any database tables or modifications to the database that the add-on</p>
</x-filament.modal-content>
