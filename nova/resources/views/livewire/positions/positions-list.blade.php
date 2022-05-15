<div class="space-y-6" x-data="filtersPanel()">
    @if ($reordering)
        <x-panel.purple icon="arrow-sort" title="Change Sorting Order">
            <div class="space-y-4">
                <p>Positions will appear in the order below whenever they're shown throughout Nova. To change the sorting of the positions, drag them to the desired order. Click Finish to return to the management view.</p>

                <div>
                    <x-button type="button" wire:click="stopReordering" color="purple-outline">Finish</x-button>
                </div>
            </div>
        </x-panel.purple>
    @endif

    <x-panel x-bind="parent" class="{{ $reordering ? 'overflow-hidden' : '' }}">
        @if (! $reordering)
            <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find position(s) by name or assigned department name" wire:model="search">
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

                <div class="shrink flex justify-between md:justify-start items-center space-x-4">
                    <x-button type="button" size="none" :color="$isFiltered ? 'blue-text' : 'gray-text'" x-bind="trigger">
                        <div class="flex items-center space-x-2">
                            @icon('filter', 'h-6 w-6 md:h-5 md:w-5')
                            <span>Filters</span>
                            @if ($activeFilterCount > 0)
                                <x-badge color="blue" size="xs">{{ $activeFilterCount }}</x-badge>
                            @endif
                        </div>
                    </x-button>

                    @can('update', $positions->first())
                        <div class="hidden md:block w-px h-6 border-l border-gray-100 dark:border-gray-200/10"></div>

                        <x-button type="button" size="none" color="gray-text" wire:click="startReordering">
                            <div class="flex items-center space-x-2">
                                @icon('arrow-sort', 'h-6 w-6 md:h-5 md:w-5')
                                <span>Reorder</span>
                            </div>
                        </x-button>
                    @endcan
                </div>
            </x-content-box>

            <x-panel.filters x-bind="panel" x-cloak>
                <livewire:livewire-filters-select :filter="$filters['department']" />
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
                <livewire:livewire-filters-radio :filter="$filters['assigned_character']" />
                <livewire:livewire-filters-radio :filter="$filters['available_count']" />
            </x-panel.filters>
        @endif

        <x-table-list columns="4" wire:sortable="reorder">
            @if ($positions->count() > 0 && ! $reordering)
                <x-slot:header>
                    <div>Name</div>
                    <div class="text-center">Available Slots</div>
                    <div class="text-center">Assigned Characters</div>
                    <div>Status</div>
                </x-slot:header>
            @endif

            @forelse ($positions as $position)
                <x-table-list.row wire:sortable.item="{{ $position->id }}" wire:key="department-{{ $position->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="shrink-0 cursor-move mr-2 md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 md:h-5 md:w-5 text-gray-500" />
                            </div>
                        @endif

                        <div class="font-medium">
                            {{ $position->name }}
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <div class="w-full text-base md:text-lg md:font-medium md:text-center text-gray-600 dark:text-gray-400">
                            @if ($position->status->name() === 'active')
                                {{ $position->available }} <span class="inline md:hidden">available @choice('slot|slots', $position->available)</span>
                            @else
                                <span class="text-gray-400 dark:text-gray-600">&ndash;</span>
                            @endif
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <div class="w-full text-base md:text-lg md:font-medium md:text-center text-gray-600 dark:text-gray-400">
                            {{ $position->active_characters_count }} <span class="inline md:hidden">assigned @choice('character|characters', $position->active_characters_count)</span>
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <x-badge size="xs" :color="$position->status->color()">{{ $position->status->displayName() }}</x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot:controls>
                            <x-dropdown placement="bottom-end">
                                <x-slot:trigger>
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot:trigger>

                                <x-dropdown.group>
                                    @can('view', $position)
                                        <x-dropdown.item :href="route('positions.show', $position)" icon="show" data-cy="view">
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $position)
                                        <x-dropdown.item :href="route('positions.edit', $position)" icon="edit" data-cy="edit">
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('duplicate', $position)
                                        <x-dropdown.item type="button" icon="copy" @click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($position) }});" data-cy="duplicate">
                                            <span>Duplicate</span>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('delete', $position)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($position) }});" data-cy="delete">
                                            <span>Delete</span>
                                        </x-dropdown.item-danger>
                                    </x-dropdown.group>
                                @endcan
                            </x-dropdown>
                        </x-slot:controls>
                    @endif
                </x-table-list.row>
            @empty
                <x-slot:emptyMessage>
                    <x-search-not-found>
                        No positions found
                    </x-search-not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if (! $reordering)
                <x-slot:footer>
                    {{ $positions->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        </x-table-list>
    </x-panel>
</div>