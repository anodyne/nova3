<x-filament.modal-content :$action title="Delete role?">
    <x-text>
        Are you sure you want to delete the
        <strong>{{ $record->display_name }}</strong>
        role? You won’t be able to recover it.
    </x-text>

    <x-text>Any user assigned this role will lose access to what this role provides.</x-text>
</x-filament.modal-content>
