@extends($meta->template)

@section('content')
    @livewire('characters:list')

    <x-tips section="characters" />

    <x-modal color="danger" title="Delete character?" icon="warning" :url="route('characters.delete')">
        <x-slot:footer>
            <x-button-filled type="submit" form="form" color="danger">
                Delete
            </x-button-filled>
            <x-button-outline color="danger" @click="$dispatch('modal-close')">
                Cancel
            </x-button-outline>
        </x-slot:footer>
    </x-modal>

    <x-modal color="primary" title="Deactivate character?" icon="remove" :url="route('characters.confirm-deactivate')" event="modal-deactivate">
        <x-slot:footer>
            <x-button-filled type="submit" form="form-deactivate">
                Deactivate
            </x-button-filled>
            <x-button-outline @click="$dispatch('modal-close')">
                Cancel
            </x-button-outline>
        </x-slot:footer>
    </x-modal>
@endsection
