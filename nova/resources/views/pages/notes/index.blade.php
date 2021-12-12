@extends($meta->template)

@section('content')
    <x-page-header title="My Notes">
        <x-slot name="controls">
            @if ($notes->count() > 0)
                <x-link :href="route('notes.create')" color="blue" data-cy="create">
                    Add Note
                </x-link>
            @endif
        </x-slot>
    </x-page-header>

    @if (auth()->user()->notes()->count() === 0)
        <x-empty-state
            image="notes"
            message="Notes help keep your thoughts organized about your game, a story idea, or even as a scratchpad for your next great story post."
            label="Add a note now"
            :link="route('notes.create')"
        ></x-empty-state>
    @else
        <x-panel>
            <x-content-box height="xs">
                <x-search-filter placeholder="Find a note..." :search="$search" />
            </x-content-box>

            <ul>
                @forelse ($notes as $note)
                    <li class="border-t border-gray-6">
                        <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-200 ease-in-out">
                            <x-content-box class="flex items-center">
                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <div class="font-medium truncate">
                                            {{ $note->title }}
                                        </div>
                                        <p class="mt-1 text-sm text-gray-11">{{ $note->summary }}</p>
                                    </div>
                                </div>
                                <div class="ml-5 shrink-0 leading-0">
                                    <x-dropdown placement="bottom-end">
                                        <x-slot name="trigger">
                                            <x-icon.more class="h-6 w-6" />
                                        </x-slot>

                                        <x-dropdown.group>
                                            <x-dropdown.item :href="route('notes.show', $note)" icon="show">
                                                <span>View</span>
                                            </x-dropdown.item>
                                            <x-dropdown.item :href="route('notes.edit', $note)" icon="edit">
                                                <span>Edit</span>
                                            </x-dropdown.item>
                                            <x-dropdown.item type="submit" icon="copy" form="duplicate-{{ $note->id }}" data-cy="duplicate">
                                                <span>Duplicate</span>

                                                <x-slot name="buttonForm">
                                                    <x-form :action="route('notes.duplicate', $note)" id="duplicate-{{ $note->id }}" class="hidden" />
                                                </x-slot>
                                            </x-dropdown.item>
                                        </x-dropdown.group>

                                        <x-dropdown.group>
                                            <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($note) }});" data-cy="delete">
                                                <span>Delete</span>
                                            </x-dropdown.item-danger>
                                        </x-dropdown.group>
                                    </x-dropdown>
                                </div>
                            </x-content-box>
                        </div>
                    </li>
                @empty
                    <x-search-not-found>
                        No notes found
                    </x-search-not-found>
                @endforelse
            </ul>

            <div class="px-4 py-2 border-t border-gray-6 sm:px-6 sm:py-3">
                {{ $notes->withQueryString()->links() }}
            </div>
        </x-panel>

        <x-tips section="notes" />

        <x-modal color="red" title="Delete Note?" icon="warning" :url="route('notes.delete')">
            <x-slot name="footer">
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
            </x-slot>
        </x-modal>
    @endif
@endsection
