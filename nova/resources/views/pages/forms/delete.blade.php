<x-filament.modal-content icon="trash" title="Delete form?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong> form?
        You won’t be able to recover it.
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
