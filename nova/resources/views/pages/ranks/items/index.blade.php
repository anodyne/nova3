@extends($meta->template)

@section('content')
    <x-page-header title="Rank Items" pretitle="Ranks">
        <x-slot:controls>
            @if ($itemCount > 0)
                @can('create', $item)
                    <x-link :href="route('ranks.items.create')" color="blue" data-cy="create">
                        Add Rank Item
                    </x-link>
                @endcan
            @endif
        </x-slot:controls>
    </x-page-header>

    @if ($itemCount === 0)
        <x-empty-state.large
            image="asset-selection"
            message="Rank items bring the rank group, rank name, and images together in a simple and easy-to-use rank experience."
            label="Add a rank item now"
            :link="route('ranks.items.create')"
            :link-access="gate()->allows('create', $item)"
        ></x-empty-state.large>
    @else
        @livewire('rank-items:list')

        <x-tips section="ranks" />

        <x-modal color="red" title="Delete rank item?" icon="warning" :url="route('ranks.items.delete')">
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
    @endif
@endsection
