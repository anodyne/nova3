<x-filament.modal-content :$action title="Ban user?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to un-ban
        <strong>{{ $record->name }}</strong>?
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
