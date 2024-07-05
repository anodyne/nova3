<x-filament.modal-content icon="trash" title="Delete form submission?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to delete this form submission for the
        <em class="italic">{{ $record->form->name }}</em> form from
        <strong class="font-semibold">{{ $record->owner->name }}</strong>?
        You won’t be able to recover it.
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
