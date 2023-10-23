<x-filament.modal-content icon="remove" title="Deactivate user?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to deactivate
        <strong class="font-semibold">{{ $record->name }}</strong>'s
        user account? This will also deactivate all characters assigned to them who are not jointly owned with another user.
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
