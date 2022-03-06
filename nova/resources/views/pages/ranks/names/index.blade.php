@extends($meta->template)

@section('content')
    <x-page-header title="Rank Names" pretitle="Ranks">
        <x-slot:controls>
            @if ($nameCount > 0)
                @can('create', 'Nova\Ranks\Models\RankName')
                    <x-link :href="route('ranks.names.create')" color="blue" data-cy="create">
                        Add Rank Name
                    </x-link>
                @endcan
            @endif
        </x-slot:controls>
    </x-page-header>

    @if ($nameCount === 0)
        <x-empty-state
            image="diary"
            message="Rank names eliminate the repetitive task of setting the name of a rank by letting you re-use names across all of your rank items."
            label="Add a rank name now"
            :link="route('ranks.names.create')"
        ></x-empty-state>
    @else
        @livewire('rank-names:list')

        <x-tips section="ranks" />

        <x-modal color="red" title="Delete rank name?" icon="warning" :url="route('ranks.names.delete')">
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
