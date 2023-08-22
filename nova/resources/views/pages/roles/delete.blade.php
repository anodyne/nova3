<x-filament.modal-content icon="trash" title="Delete role?">
    <p>
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->display_name }}</strong>
        role? You won't be able to recover it.
    </p>

    <p>Any user assigned this role will lose access to what this role provides.</p>
</x-filament.modal-content>
