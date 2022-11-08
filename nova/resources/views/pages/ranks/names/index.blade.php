@extends($meta->template)

@section('content')
    @livewire('rank-names:list')

    <x-tips section="ranks" />

    <x-modal color="danger" title="Delete rank name?" icon="warning" :url="route('ranks.names.delete')">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form" color="danger" full-width>
                    Delete
                </x-button>
            </span>
            <span class="mt-3 flex w-full sm:mt-0 sm:col-start-1">
                <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                    Cancel
                </x-button>
            </span>
        </x-slot:footer>
    </x-modal>
@endsection
