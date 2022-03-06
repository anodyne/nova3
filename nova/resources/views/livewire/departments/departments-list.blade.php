<div class="space-y-6" x-data="filtersPanel()">
    @if ($reordering)
        <x-panel>
            <x-content-box class="sm:rounded-lg bg-purple-3 ring-1 ring-purple-6">
                <div class="flex">
                    <div class="shrink-0">
                        @icon('arrow-sort', 'h-7 w-7 md:h-6 md:w-6 text-purple-9')
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg md:text-base font-semibold md:font-medium text-purple-11">
                            Change Sorting Order
                        </h3>
                        <div class="mt-2 text-base md:text-sm text-purple-11">
                            <p>Departments will appear in the order below whenever they're shown throughout Nova. To change the sorting of the departments, drag them to the desired order. Click Finish to return to the management view.</p>
                        </div>
                        <x-button type="button" wire:click="stopReordering" color="purple-outline" class="mt-4">Finish</x-button>
                    </div>
                </div>
            </x-content-box>
        </x-panel>
    @endif

    <x-panel x-bind="parent" class="{{ $reordering ? 'overflow-hidden' : '' }}">
        @if (! $reordering)
            <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find department by name or position name..." wire:model="search">
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

                    @can('update', $departments->first())
                        <div class="hidden md:block w-px h-6 border-l border-gray-6"></div>

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
            </x-panel.filters>
        @endif

        <ul class="divide-y divide-gray-6" wire:sortable="reorder">
            @if ($departments->count() > 0 && ! $reordering)
                <li class="hidden md:block border-t border-gray-6 bg-gray-2 text-xs leading-4 font-semibold text-gray-9 uppercase tracking-wider">
                    <div class="block">
                        <x-content-box height="xs" class="flex">
                            <div class="min-w-0 flex-1 grid grid-cols-3 gap-4">
                                <div>Name</div>
                                <div># of Positions</div>
                                <div>Status</div>
                            </div>
                            <div class="block ml-4 w-6"></div>
                        </x-content-box>
                    </div>
                </li>
            @endif

            @forelse ($departments as $department)
                <li wire:sortable.item="{{ $department->id }}" wire:key="department-{{ $department->id }}">
                    <div class="block hover:bg-gray-2 focus:outline-none focus:bg-gray-2 transition duration-200 ease-in-out">
                        <x-content-box height="sm" class="flex">
                            <div class="min-w-0 flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center">
                                    @if ($reordering)
                                        <div class="shrink-0 cursor-move mr-2 md:mr-4" wire:sortable.handle>
                                            <x-icon.move-handle class="h-6 w-6 md:h-5 md:w-5 text-gray-9" />
                                        </div>
                                    @endif

                                    <div class="font-medium truncate">
                                        {{ $department->name }}
                                    </div>
                                </div>

                                <div @class([
                                    'flex items-center',
                                    'ml-8 md:ml-0' => $reordering
                                ])>
                                    <div class="text-base md:text-sm text-gray-11">
                                        {{ $department->positions_count }} @choice('position|positions', $department->positions_count)
                                    </div>
                                </div>

                                <div @class([
                                    'flex items-center',
                                    'ml-8 md:ml-0' => $reordering
                                ])>
                                    <x-badge size="xs" :color="$department->status->color()">
                                        {{ $department->status->displayName() }}
                                    </x-badge>
                                </div>
                            </div>

                            @if (! $reordering)
                                <div class="ml-4 flex md:items-center">
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
                                                <x-dropdown.item :href="route('positions.index', $department)" icon="list" data-cy="edit">
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
                                </div>
                            @endif
                        </x-content-box>
                    </div>
                </li>
            @empty
                <li class="border-t border-gray-6">
                    <x-search-not-found>
                        No departments found
                    </x-search-not-found>
                </li>
            @endforelse
        </ul>

        @if (! $reordering)
            <x-content-box height="xs" class="border-t border-gray-6">
                {{ $departments->withQueryString()->links() }}
            </x-content-box>
        @endif
    </x-panel>
</div>