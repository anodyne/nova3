@extends($meta->template)

@section('content')
    <x-page-header title="Rank Groups" pretitle="Ranks">
        <x-slot:controls>
            @if ($groupCount > 0)
                @can('create', $group)
                    <x-link :href="route('ranks.groups.create')" color="primary" data-cy="create">
                        Add Rank Group
                    </x-link>
                @endcan
            @endif
        </x-slot:controls>
    </x-page-header>

    @if ($groupCount === 0)
        <x-empty-state.large
            image="organizer"
            message="Rank groups are a simple way to collect related rank items together for simpler searching and selecting ranks in Nova."
            label="Add a rank group now"
            :link="route('ranks.groups.create')"
            :link-access="gate()->allows('create', $group)"
        ></x-empty-state.large>
    @else
        @livewire('rank-groups:list')

        <x-tips section="ranks" />

        <x-modal color="error" title="Delete rank group?" icon="warning" :url="route('ranks.groups.delete')">
            <x-slot:footer>
                <span class="flex w-full sm:col-start-2">
                    <x-button type="submit" type="submit" form="form" color="error" full-width>
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

        <x-modal color="primary" title="Duplicate rank group" icon="copy" :url="route('ranks.groups.confirm-duplicate')" event="modal-duplicate" :wide="true">
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
