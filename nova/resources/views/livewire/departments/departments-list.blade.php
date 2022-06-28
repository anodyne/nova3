<div class="space-y-6" x-data="filtersPanel()">
    @if ($reordering)
        <x-panel.info icon="arrow-sort" title="Change Sorting Order">
            <div class="space-y-4">
                <p>Departments will appear in the order below whenever they're shown throughout Nova. To change the sorting of the departments, drag them to the desired order. Click Finish to return to the management view.</p>

                <div>
                    <x-button type="button" wire:click="stopReordering" color="info-outline">Finish</x-button>
                </div>
            </div>
        </x-panel.info>
    @endif

    <x-panel x-bind="parent" class="{{ $reordering ? 'overflow-hidden' : '' }}">
        @if (! $reordering)
            <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find department(s) by name or assigned position names" wire:model="search">
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
                    <x-button type="button" size="none" :color="$isFiltered ? 'primary-text' : 'gray-text'" x-bind="trigger">
                        <div class="flex items-center space-x-2">
                            @icon('filter', 'h-6 w-6 md:h-5 md:w-5')
                            <span>Filters</span>
                            @if ($activeFilterCount > 0)
                                <x-badge color="primary">{{ $activeFilterCount }}</x-badge>
                            @endif
                        </div>
                    </x-button>

                    @can('update', $departments->first())
                        <div class="hidden md:block w-px h-6 border-l border-gray-200 dark:border-gray-200/10"></div>

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
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
                <livewire:livewire-filters-radio :filter="$filters['position_count']" />
            </x-panel.filters>
        @endif

        <x-table-list columns="3" wire:sortable="reorder">
            @if ($departments->count() > 0 && ! $reordering)
                <x-slot:header>
                    <div>Name</div>
                    <div class="text-center"># of Positions</div>
                    <div>Status</div>
                </x-slot:header>
            @endif

            @forelse ($departments as $department)
                <x-table-list.row wire:sortable.item="{{ $department->id }}" wire:key="department-{{ $department->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="shrink-0 cursor-move mr-2 md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 md:h-5 md:w-5 text-gray-500" />
                            </div>
                        @endif

                        <div class="font-medium">
                            {{ $department->name }}
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <div class="w-full text-base md:text-lg md:font-medium md:text-center text-gray-600 dark:text-gray-400">
                            {{ $department->positions_count }} <span class="inline md:hidden">@choice('position|positions', $department->positions_count)</span>
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <x-badge :color="$department->status->color()">
                            {{ $department->status->displayName() }}
                        </x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot:controls>
                            <x-dropdown placement="bottom-end">
                                <x-slot:trigger>
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot:trigger>

                                <x-dropdown.group>
                                    @can('view', $department)
                                        <x-dropdown.item :href="route('departments.show', $department)" icon="show" data-cy="view">
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $department)
                                        <x-dropdown.item :href="route('departments.edit', $department)" icon="edit" data-cy="edit">
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('duplicate', $department)
                                        <x-dropdown.item type="button" icon="copy" @click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($department) }});" data-cy="duplicate">
                                            <span>Duplicate</span>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('update', $department)
                                    <x-dropdown.group>
                                        <x-dropdown.item :href="route('positions.index', 'department='.$department->id)" icon="list" data-cy="edit">
                                            <span>Positions</span>
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                @endcan

                                @can('delete', $department)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($department) }});" data-cy="delete">
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
                        No departments found
                    </x-search-not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if (! $reordering)
                <x-slot:footer>
                    {{ $departments->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        </x-table-list>
    </x-panel>
</div>
