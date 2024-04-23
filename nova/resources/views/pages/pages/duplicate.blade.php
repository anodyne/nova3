<x-filament.modal-content icon="copy">
    <x-slot name="title">Duplicate {{ $record->is_basic ? 'basic' : 'advanced' }} page?</x-slot>

    <x-text>
        Are you sure you want to duplicate the
        <x-text.strong>{{ $record->name }}</x-text.strong>
        page?
    </x-text>
</x-filament.modal-content>
