<x-filament.modal-content :$action title="Delete form?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to delete the
        <strong>{{ $record->name }}</strong> form?
        You won’t be able to recover it.
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
