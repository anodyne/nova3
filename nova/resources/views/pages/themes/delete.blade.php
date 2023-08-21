<x-filament.modal-content icon="trash" title="Delete theme?">
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        theme?
    </p>

    <p>
        The files for the theme will remain on the server, but you will no longer be able to use the theme on your
        public-facing site.
    </p>
</x-filament.modal-content>
