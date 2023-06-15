@extends($meta->template)

@section('content')
    @livewire('positions:list')

    <x-tips section="positions" />

    <x-modal color="danger" title="Delete position?" icon="trash" :url="route('positions.delete')">
        <x-slot name="footer">
            <x-button.filled type="submit" form="form" color="danger">Delete</x-button.filled>
            <x-button.outline x-on:click="$dispatch('modal-close')">Cancel</x-button.outline>
        </x-slot>
    </x-modal>

    <x-modal color="primary" title="Duplicate position" icon="copy" :url="route('positions.confirm-duplicate')" event="modal-duplicate" :wide="true">
        <x-slot name="footer">
            <x-button.filled type="submit" form="form-duplicate">Duplicate</x-button.filled>
            <x-button.outline x-on:click="$dispatch('modal-close')">Cancel</x-button.outline>
        </x-slot>
    </x-modal>
@endsection
