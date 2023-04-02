<x-panel x-data="filtersPanel()" x-bind="parent" class="{{ $reordering ? 'overflow-hidden' : '' }}">
    <x-panel.header title="Positions" message="The jobs or stations characters are assigned to for display on your manifests.">
        @if (! $reordering)
            <x-slot:actions>
                @can('update', $positions->first())
                    <x-link tag="button" color="gray" leading="arrow-sort" wire:click="startReordering">
                        Reorder
                    </x-link>
                @endcan

                @if ($positions->count() > 0)
                    @can('create', $positionClass)
                        <x-button-filled tag="a" :href="route('positions.create', 'department='.request('department'))" leading="add" data-cy="create">
                            Add a position
                        </x-button-filled>
                    @endcan
                @endif
            </x-slot:actions>
        @else
            <x-slot:message>
                <x-panel.primary icon="arrow-sort" title="Change sorting order" class="mt-4">
                    <div class="space-y-4">
                        <p>Positions will appear in the order below whenever they're shown throughout Nova. To change the sorting of the positions, drag them to the desired order. Click Finish to return to the management view.</p>

                        <div>
                            <x-button-filled wire:click="stopReordering">Finish</x-button-filled>
                        </div>
                    </div>
                </x-panel.primary>
            </x-slot:message>
        @endif
    </x-panel.header>

    @if (! $reordering)
        @if ($positionCount === 0)
            <x-empty-state.large
                icon="list"
                title="Start by creating a position"
                message="Positions are the jobs or stations that characters can be assigned to for display on your manifests."
                label="Add a position"
                :link="route('positions.create', 'department='.request('department'))"
                :link-access="gate()->allows('create', $positionClass)"
            ></x-empty-state.large>
        @else
            <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find position(s) by name or assigned department name" wire:model="search">
                            <x-slot:leadingAddOn>
                                @icon('search', 'h-5 w-5')
                            </x-slot:leadingAddOn>

                            @if ($search)
                                <x-slot:trailingAddOn>
                                    <x-link tag="button" color="gray" wire:click="$set('search', '')">
                                        @icon('close', 'h-5 w-5')
                                    </x-link>
                                </x-slot:trailingAddOn>
                            @endif
                        </x-input.text>
                    </x-input.group>
                </div>

                <div class="shrink flex justify-between md:justify-start items-center space-x-4">
                    <x-link
                        tag="button"
                        :color="$isFiltered ? 'primary' : 'gray'"
                        x-bind="trigger"
                        leading="filter"
                    >
                        <span>Filters</span>
                        @if ($activeFilterCount > 0)
                            <x-badge color="primary" size="sm" class="ml-2">{{ $activeFilterCount }}</x-badge>
                        @endif
                    </x-link>
                </div>
            </x-content-box>

            <x-panel.filters x-bind="panel" x-cloak>
                <livewire:livewire-filters-select :filter="$filters['department']" />
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
                <livewire:livewire-filters-radio :filter="$filters['assigned_character']" />
                <livewire:livewire-filters-radio :filter="$filters['available_count']" />
            </x-panel.filters>
        @endif
    @endif

    <x-table-list columns="4" wire:sortable="reorder">
        @if ($positionCount > 0)
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

                        <x-table-list.primary-column>
                            {{ $position->name }}
                        </x-table-list.primary-column>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <div class="w-full text-base md:text-center text-gray-600 dark:text-gray-400">
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
                        <div class="w-full text-base md:text-center text-gray-600 dark:text-gray-400">
                            {{ $position->active_characters_count }} <span class="inline md:hidden">assigned @choice('character|characters', $position->active_characters_count)</span>
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <x-badge :color="$position->status->color()">{{ $position->status->displayName() }}</x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot:actions>
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
                        </x-slot:actions>
                    @endif
                </x-table-list.row>
            @empty
                <x-slot:emptyMessage>
                    <x-empty-state.not-found
                        entity="position"
                        :search="$search"
                        :primary-access="gate()->allows('create', $positionClass)"
                    >
                        <x-slot:primary>
                            <x-button-filled tag="a" :href="route('positions.create', 'department='.request('department'))">
                                Add a position
                            </x-button-filled>
                        </x-slot:primary>

                        <x-slot:secondary>
                            <x-button-outline wire:click="$set('search', '')">Clear search</x-button-outline>
                        </x-slot:secondary>
                    </x-empty-state.not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if (! $reordering && $positions->count() > 0)
                <x-slot:footer>
                    {{ $positions->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        @endif
    </x-table-list>
</x-panel>
