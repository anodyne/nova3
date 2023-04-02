@extends($meta->template)

@section('content')
    @livewire('roles:list')

    <x-tips section="roles" />

    <x-modal color="danger" title="Delete role?" icon="warning" :url="route('roles.delete')">
        <x-slot:footer>
            <x-button-filled type="submit" form="form" color="danger">
                Delete
            </x-button-filled>
            <x-button-outline color="danger" @click="$dispatch('modal-close')">
                Cancel
            </x-button-outline>
        </x-slot:footer>
    </x-modal>
@endsection
