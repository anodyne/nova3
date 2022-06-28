@extends($meta->template)

@section('content')
    <x-page-header title="Positions" x-data="{}">
        <x-slot:controls>
            @if ($positionCount > 0)
                @can('create', $position)
                    <x-link :href="route('positions.create')" color="primary" data-cy="create">
                        Add Position
                    </x-link>
                @endcan
            @endif
        </x-slot:controls>
    </x-page-header>

    @if ($positionCount === 0)
        <x-empty-state.large
            image="organizer"
            message="Positions are the jobs or stations that characters can be assigned to for display on your manifests."
            label="Add a position now"
            :link="route('positions.create')"
            :link-access="gate()->allows('create', $position)"
        ></x-empty-state.large>
    @else
        @livewire('positions:list')

        <x-tips section="positions" />

        <x-modal color="error" title="Delete Position?" icon="warning" :url="route('positions.delete')">
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
    @endif
@endsection
