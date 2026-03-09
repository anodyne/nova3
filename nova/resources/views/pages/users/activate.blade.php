<x-filament.modal-content :$action title="Activate user?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to activate
        <strong>{{ $record->name }}</strong>’s
        user account? You can choose below whether to activate their previous character as well.
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
