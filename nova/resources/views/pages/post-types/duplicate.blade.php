<x-filament.modal-content :$action title="Duplicate post type?">
    <x-text variant="strong">
        Are you sure you want to duplicate the
        <strong>{{ $record->name }}</strong>
        post type? This will copy the original post type’s field settings and options, which you can change after
        duplication.
    </x-text>
</x-filament.modal-content>
