@extends($meta->template)

@section('content')
    @livewire('post-types:list')

    <x-tips section="post-types" />

    <x-modal color="danger" title="Delete Post Type?" icon="warning" :url="route('post-types.delete')">
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
