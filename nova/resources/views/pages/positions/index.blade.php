@extends($meta->template)

@section('content')
    @livewire('positions:list')

    <x-tips section="positions" />

    <x-modal color="danger" title="Delete position?" icon="delete" :url="route('positions.delete')">
        <x-slot:footer>
            <x-button-filled type="submit" form="form" color="danger">
                Delete
            </x-button-filled>
            <x-button-outline color="danger" @click="$dispatch('modal-close')">
                Cancel
            </x-button-outline>
        </x-slot:footer>
    </x-modal>

    <x-modal color="primary" title="Duplicate position" icon="copy" :url="route('positions.confirm-duplicate')" event="modal-duplicate" :wide="true">
        <x-slot:footer>
            <x-button-filled type="submit" form="form-duplicate">
                Duplicate
            </x-button-filled>
            <x-button-outline @click="$dispatch('modal-close')">
                Cancel
            </x-button-outline>
        </x-slot:footer>
    </x-modal>
@endsection
