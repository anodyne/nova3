@extends($meta->template)

@section('content')
    <x-page-header title="My Notes">
        <x-slot:controls>
            @if ($noteCount > 0)
                <x-link :href="route('notes.create')" color="blue" data-cy="create">
                    Add Note
                </x-link>
            @endif
        </x-slot:controls>
    </x-page-header>

    @if ($noteCount === 0)
        <x-empty-state.large
            icon="gauge"
            message="Notes help keep your thoughts organized about your game, a story idea, or even as a scratchpad for your next great story post."
            label="Add a note now"
            :link="route('notes.create')"
            :link-access="true"
        ></x-empty-state.large>
    @else
        @livewire('notes:list')

        <x-tips section="notes" />

        <x-modal color="red" title="Delete Note?" icon="warning" :url="route('notes.delete')">
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
