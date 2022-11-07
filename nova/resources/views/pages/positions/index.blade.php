@extends($meta->template)

@section('content')
    @livewire('positions:list')

    <x-tips section="positions" />

    <x-modal color="error" title="Delete position?" icon="warning" :url="route('positions.delete')">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form" color="error" full-width>
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

    <x-modal color="primary" title="Duplicate position" icon="copy" :url="route('positions.confirm-duplicate')" event="modal-duplicate" :wide="true">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form-duplicate" color="primary" full-width>
                    Duplicate
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
