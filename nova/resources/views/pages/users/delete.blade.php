<x-filament.modal-content icon="trash" title="Delete user?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to delete
        <strong class="font-semibold">{{ $record->name }}</strong>’s
        user account?
    </p>

    <p>They will no longer be able to access the site.</p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
