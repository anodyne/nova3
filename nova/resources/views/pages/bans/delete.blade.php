<x-filament.modal-content :$action title="Delete ban?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to delete
        <strong class="font-semibold">{{ $record->name }}</strong>’s
        ban?
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
