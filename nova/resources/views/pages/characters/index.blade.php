@extends($meta->template)

@section('content')
    <x-page-header title="All Characters">
        <x-slot:controls>
            @can('createAny', Nova\Characters\Models\Character::class)
                <x-link :href="route('characters.create')" color="blue" data-cy="create">
                    Add Character
                </x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    @livewire('characters:list')

    <x-tips section="characters" />

    <x-modal color="red" title="Delete character?" icon="warning" :url="route('characters.delete')">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form" color="red" full-width>
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

    <x-modal color="blue" title="Deactivate character?" icon="copy" :url="route('characters.confirm-deactivate')" event="modal-deactivate">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form-deactivate" color="blue" full-width>
                    Deactivate
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
