@extends($meta->template)

@section('content')
    @livewire('notes:list')

    <x-tips section="notes" />

    <x-modal color="danger" title="Delete note?" icon="delete" :url="route('notes.delete')">
        <x-slot:footer>
            <x-button-filled type="submit" form="form" color="danger">
                Delete note
            </x-button-filled>

            <x-button-outline color="danger" @click="$dispatch('modal-close')">
                Cancel
            </x-button-outline>
        </x-slot:footer>
    </x-modal>
@endsection
