<x-panel x-data="filtersPanel()" x-bind="parent">
    <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
        <div class="flex-1">
            <x-input.group>
                <x-input.text placeholder="Find notes..." wire:model="search">
                    <x-slot:leadingAddOn>
                        @icon('search', 'h-5 w-5')
                    </x-slot:leadingAddOn>

                    @if ($search)
                        <x-slot:trailingAddOn>
                            <x-button size="none" color="gray-text" wire:click="$set('search', '')">
                                @icon('close', 'h-5 w-5')
                            </x-button>
                        </x-slot:trailingAddOn>
                    @endif
                </x-input.text>
            </x-input.group>
        </div>

        {{-- <div class="shrink flex justify-between md:justify-start items-center space-x-4">
            <x-button type="button" size="none" :color="$isFiltered ? 'blue-text' : 'gray-text'" x-bind="trigger">
                <div class="flex items-center space-x-2">
                    @icon('filter', 'h-5 w-5')
                    <span>Filters</span>
                    @if ($activeFilterCount > 0)
                        <x-badge color="blue" size="xs">{{ $activeFilterCount }}</x-badge>
                    @endif
                </div>
            </x-button>

            <div class="hidden md:block w-px h-6 border-l border-gray-300"></div>

            <x-button size="none" color="gray-text" wire:click="clearAll">Clear all</x-button>
        </div> --}}
    </x-content-box>

    {{-- <x-panel.filters x-bind="panel" x-cloak>
        <livewire:livewire-filters-checkbox :filter="$filters['status']" />

        <livewire:livewire-filters-radio :filter="$filters['assigned_characters']" />
    </x-panel.filters> --}}

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
                    <div class="font-medium truncate">{{ $note->title }}</div>
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
                            <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($note) }});" data-cy="delete">
                                <span>Delete</span>
                            </x-dropdown.item-danger>
                        </x-dropdown.group>
                    </x-dropdown>
                </x-slot:controls>
            </x-table-list.row>
        @empty
            <x-slot:emptyMessage>
                <x-search-not-found>
                    No notes found
                </x-search-not-found>
            </x-slot:emptyMessage>
        @endforelse

        <x-slot:footer>
            {{ $notes->withQueryString()->links() }}
        </x-slot:footer>
    </x-table-list>
</x-panel>