@extends($meta->template)

@section('content')
    @livewire('departments:list')

    <x-tips section="departments" />

    <x-modal color="danger" title="Delete department?" icon="warning" :url="route('departments.delete')">
        <x-slot:footer>
            <x-button-filled type="submit" form="form" color="danger">
                Delete
            </x-button-filled>
            <x-button-outline color="danger" @click="$dispatch('modal-close')">
                Cancel
            </x-button-outline>
        </x-slot:footer>
    </x-modal>

    <x-modal color="primary" title="Duplicate department" icon="copy" :url="route('departments.confirm-duplicate')" event="modal-duplicate" :wide="true">
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
