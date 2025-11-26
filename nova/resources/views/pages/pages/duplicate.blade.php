<x-filament.modal-content :$action>
    <x-slot name="title">Duplicate {{ $record->is_basic ? 'basic' : 'advanced' }} page?</x-slot>

    <x-text>
        Are you sure you want to duplicate the
        <strong>{{ $record->name }}</strong>
        page?
    </x-text>
</x-filament.modal-content>
