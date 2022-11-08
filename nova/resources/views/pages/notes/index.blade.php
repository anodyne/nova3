@extends($meta->template)

@section('content')
    @livewire('notes:list')

    <x-tips section="notes" />

    <x-modal color="danger" title="Delete note?" icon="delete" :url="route('notes.delete')">
        <x-slot:footer>
            <x-button type="submit" form="form" color="danger" full-width>
                Delete
            </x-button>

            <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                Cancel
            </x-button>
        </x-slot:footer>
    </x-modal>
@endsection
