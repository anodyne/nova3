@extends($__novaTemplate)

@section('content')
    <x-page-header title="My Notes">
        <x-slot name="controls">
            @if ($notes->count() > 0)
                <a href="{{ route('notes.create') }}" class="button button-primary" data-cy="create">
                    Add Note
                </a>
            @endif
        </x-slot>
    </x-page-header>

    @if (auth()->user()->notes()->count() === 0)
        <x-empty-state
            image="notes"
            message="Notes are a great way to keep your thoughts organized, be it about things you need to do for the game, a story idea, or as a scratchpad for your next great story post."
            label="Add a note now"
            :link="route('notes.create')"
        ></x-empty-state>
    @else
        <x-panel>
            <div class="px-4 py-2 | sm:px-6 sm:py-3">
                <x-search-filter placeholder="Find a note..." :search="$search" />
            </div>

            <ul>
            @forelse ($notes as $note)
                <li class="border-t border-gray-200">
                    <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="px-4 py-4 flex items-center sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <div class="leading-normal font-medium truncate">
                                        {{ $note->title }}
                                    </div>
                                    <p class="mt-1 text-sm leading-5 text-gray-600">{{ $note->summary }}</p>
                                </div>
                            </div>
                            <div class="ml-5 flex-shrink-0 leading-0">
                                <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                    <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

                                    <a href="{{ route('notes.show', $note) }}" class="{{ $component->link() }}">
                                        @icon('show', $component->icon())
                                        <span>View</span>
                                    </a>

                                    <a href="{{ route('notes.edit', $note) }}" class="{{ $component->link() }}">
                                        @icon('edit', $component->icon())
                                        <span>Edit</span>
                                    </a>

                                    <button type="submit" class="{{ $component->link() }}" form="duplicate-{{ $note->id }}" data-cy="duplicate">
                                        @icon('duplicate', $component->icon())
                                        <span>Duplicate</span>
                                    </button>
                                    <x-form :action="route('notes.duplicate', $note)" id="duplicate-{{ $note->id }}" class="hidden" />

                                    <div class="{{ $component->divider() }}"></div>
                                    <button
                                        x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($note) }});"
                                        class="{{ $component->link() }}"
                                        data-cy="delete"
                                    >
                                        @icon('delete', $component->icon())
                                        <span>Delete</span>
                                    </button>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <x-search-not-found>
                    No notes found
                </x-search-not-found>
            @endforelse
            </ul>

            <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
                {{ $notes->withQueryString()->links() }}
            </div>
        </x-panel>

        <x-tips section="notes" />

        <x-modal color="red" title="Delete Note?" icon="warning" :url="route('notes.delete')">
            <x-slot name="footer">
                <span class="flex w-full | sm:col-start-2">
                    <button form="form" class="button button-danger w-full">
                        Delete
                    </button>
                </span>
                <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                    <button x-on:click="$dispatch('modal-close')" type="button" class="button w-full">
                        Cancel
                    </button>
                </span>
            </x-slot>
        </x-modal>
    @endif
@endsection
