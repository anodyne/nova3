<x-panel x-data="filtersPanel()" x-bind="parent">
    <x-panel.header title="My notes">
        <x-slot:controls>
            <x-link :href="route('notes.create')" color="primary" data-cy="create" leading="add">
                Add a note
            </x-link>
        </x-slot:controls>
    </x-panel.header>

    @if ($noteCount === 0)
        <x-empty-state.large
            icon="note"
            message="Notes help keep your thoughts organized about your game, a story idea, or even as a scratchpad for your next great story post."
            label="Add a note"
            :link="route('notes.create')"
            :link-access="true"
        ></x-empty-state.large>
    @else
        <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
            <div class="flex-1">
                <x-input.group>
                    <x-input.text placeholder="Search for notes by their title or content" wire:model="search">
                        <x-slot:leadingAddOn>
                            @icon('search', 'h-5 w-5')
                        </x-slot:leadingAddOn>

                        @if ($search)
                            <x-slot:trailingAddOn>
                                <x-button size="none" color="light-gray-text" wire:click="$set('search', '')">
                                    @icon('close', 'h-5 w-5')
                                </x-button>
                            </x-slot:trailingAddOn>
                        @endif
                    </x-input.text>
                </x-input.group>
            </div>

            <div class="shrink flex justify-between md:justify-start items-center space-x-4">
                <x-button
                    size="none"
                    :color="$isFiltered ? 'primary-text' : 'gray-text'"
                    x-bind="trigger"
                    leading="filter"
                >
                    <span>Filters</span>
                    @if ($activeFilterCount > 0)
                        <x-badge color="primary" size="sm" class="ml-2">{{ $activeFilterCount }}</x-badge>
                    @endif
                </x-button>
            </div>
        </x-content-box>

        <x-panel.filters x-bind="panel" x-cloak>
            <livewire:livewire-filters-radio :filter="$filters['order_by']" />
        </x-panel.filters>

        <x-table-list columns="3">
            @if ($notes->total() > 0)
                <x-slot:header>
                    <div class="col-span-2">Title</div>
                    <div>Last Modified</div>
                </x-slot:header>
            @endif

            @forelse ($notes as $note)
                <x-table-list.row>
                    <div class="flex items-center md:col-span-2">
                        <x-table-list.primary-column>
                            {{ $note->title }}
                        </x-table-list.primary-column>
                    </div>

                    <div class="flex items-center ">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <time datetime="{{ $note->updated_at }}">
                                {{ $note->updated_at?->diffForHumans() }}
                            </time>
                        </div>
                    </div>

                    <x-slot:controls>
                        <x-dropdown placement="bottom-end">
                            <x-slot:trigger>
                                <x-icon.more class="h-6 w-6" />
                            </x-slot:trigger>

                            <x-dropdown.group>
                                <x-dropdown.item :href="route('notes.show', $note)" icon="show">
                                    <span>View</span>
                                </x-dropdown.item>

                                <x-dropdown.item :href="route('notes.edit', $note)" icon="edit">
                                    <span>Edit</span>
                                </x-dropdown.item>

                                <x-dropdown.item type="submit" icon="copy" form="duplicate-{{ $note->id }}" data-cy="duplicate">
                                    <span>Duplicate</span>

                                    <x-slot:buttonForm>
                                        <x-form :action="route('notes.duplicate', $note)" id="duplicate-{{ $note->id }}" class="hidden" />
                                    </x-slot:buttonForm>
                                </x-dropdown.item>
                            </x-dropdown.group>

                            <x-dropdown.group>
                                <x-dropdown.item-danger icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($note) }});" data-cy="delete">
                                    <span>Delete</span>
                                </x-dropdown.item-danger>
                            </x-dropdown.group>
                        </x-dropdown>
                    </x-slot:controls>
                </x-table-list.row>
            @empty
                <x-slot:emptyMessage>
                    <x-empty-state.not-found
                        entity="note"
                        :search="$search"
                        :primary-access="true"
                    >
                        <x-slot:primary>
                            <x-link :href="route('notes.create')" color="primary">
                                Add a note
                            </x-link>
                        </x-slot:primary>

                        <x-slot:secondary>
                            <x-button wire:click="$set('search', '')">Clear search</x-button>
                        </x-slot:secondary>
                    </x-empty-state.not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if ($notes->count() > 0)
                <x-slot:footer>
                    {{ $notes->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        </x-table-list>
    @endif
</x-panel>
