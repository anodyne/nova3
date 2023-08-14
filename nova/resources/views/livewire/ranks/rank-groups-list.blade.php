<x-panel x-data="filtersPanel()" class="{{ $reordering ? 'overflow-hidden' : '' }}">
    <x-panel.header
        title="Rank groups"
        message="Collections of related rank items for simpler searching and selecting"
        :border="$reordering"
    >
        @if (! $reordering)
            <x-slot name="actions">
                @can('update', $rankGroups->first())
                    <x-button.text type="button" color="gray" wire:click="startReordering" leading="arrows-sort">
                        Reorder
                    </x-button.text>
                @endcan

                @can('create', $rankGroupClass)
                    <x-button.filled :href="route('ranks.groups.create')" color="primary" leading="add">
                        Add
                    </x-button.filled>
                @endcan
            </x-slot>
        @else
            <x-slot name="message">
                <x-panel.primary icon="arrows-sort" title="Change sorting order" class="mt-4">
                    <div class="space-y-4">
                        <p>
                            Rank groups will appear in the order below whenever they're shown throughout Nova. To change
                            the sorting of rank groups, drag them to the desired order. Click Finish to return to the
                            management view.
                        </p>

                        <div>
                            <x-button.filled wire:click="stopReordering">Finish</x-button.filled>
                        </div>
                    </div>
                </x-panel.primary>
            </x-slot>
        @endif
    </x-panel.header>

    @if (! $reordering)
        @if ($rankGroupCount === 0)
            <x-empty-state.large
                icon="list"
                title="Start by creating a rank group"
                message="Rank groups are a simple way to collect related rank items together for simpler searching and selecting ranks in Nova."
                label="Add a rank group"
                :link="route('ranks.groups.create')"
                :link-access="gate()->allows('create', $rankGroupClass)"
            ></x-empty-state.large>
        @else
            <x-content-box
                height="sm"
                class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-6 md:space-y-0"
            >
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find rank groups by name" wire:model="search">
                            <x-slot name="leadingAddOn">
                                <x-icon name="search" size="sm"></x-icon>
                            </x-slot>

                            @if ($search)
                                <x-slot name="trailingAddOn">
                                    <x-button.text tag="button" color="gray" wire:click="$set('search', '')">
                                        <x-icon name="dismiss" size="sm"></x-icon>
                                    </x-button.text>
                                </x-slot>
                            @endif
                        </x-input.text>
                    </x-input.group>
                </div>

                <div class="flex shrink items-center justify-between space-x-4 md:justify-start">
                    <x-button.text
                        tag="button"
                        :color="$isFiltered ? 'primary' : 'gray'"
                        x-bind="trigger"
                        leading="filter"
                    >
                        <span>Filters</span>
                        @if ($activeFilterCount > 0)
                            <x-badge color="primary" size="sm" class="ml-2">{{ $activeFilterCount }}</x-badge>
                        @endif
                    </x-button.text>
                </div>
            </x-content-box>

            <x-panel.filters x-bind="panel" x-cloak>
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
                <livewire:livewire-filters-radio :filter="$filters['rank_count']" />
            </x-panel.filters>
        @endif
    @endif

    <x-table-list columns="3" wire:sortable="reorder">
        @if ($rankGroupCount > 0)
            @if ($rankGroups->count() > 0 && ! $reordering)
                <x-slot name="header">
                    <div>Name</div>
                    <div class="text-center"># of Ranks</div>
                    <div>Status</div>
                </x-slot>
            @endif

            @forelse ($rankGroups as $rankGroup)
                <x-table-list.row wire:sortable.item="{{ $rankGroup->id }}" wire:key="group-{{ $rankGroup->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="mr-2 shrink-0 cursor-move md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 text-gray-500 md:h-5 md:w-5" />
                            </div>
                        @endif

                        <x-table-list.primary-column>
                            {{ $rankGroup->name }}
                        </x-table-list.primary-column>
                    </div>

                    <div
                        @class([
                            'flex items-center',
                            'ml-8 md:ml-0' => $reordering,
                        ])
                    >
                        <div class="w-full text-base text-gray-600 dark:text-gray-400 md:text-center">
                            {{ $rankGroup->ranks_count }}
                            <span class="inline md:hidden">
                                @choice('rank item|rank items', $rankGroup->ranks_count)
                            </span>
                        </div>
                    </div>

                    <div
                        @class([
                            'flex items-center',
                            'ml-8 md:ml-0' => $reordering,
                        ])
                    >
                        <x-badge :color="$rankGroup->status->color()">
                            {{ $rankGroup->status->displayName() }}
                        </x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot name="actions">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger">
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot>

                                <x-dropdown.group>
                                    @can('view', $rankGroup)
                                        <x-dropdown.item
                                            :href="route('ranks.groups.show', $rankGroup)"
                                            icon="show"
                                            data-cy="view"
                                        >
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $rankGroup)
                                        <x-dropdown.item
                                            :href="route('ranks.groups.edit', $rankGroup)"
                                            icon="edit"
                                            data-cy="edit"
                                        >
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('duplicate', $rankGroup)
                                        <x-dropdown.item
                                            type="submit"
                                            icon="copy"
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($rankGroup) }});"
                                            data-cy="duplicate"
                                        >
                                            <span>Duplicate</span>

                                            <x-slot name="buttonForm">
                                                <x-form
                                                    :action="route('ranks.groups.duplicate', $rankGroup)"
                                                    id="duplicate-{{ $rankGroup->id }}"
                                                    class="hidden"
                                                />
                                            </x-slot>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('delete', $rankGroup)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger
                                            type="button"
                                            icon="trash"
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($rankGroup) }});"
                                            data-cy="delete"
                                        >
                                            <span>Delete</span>
                                        </x-dropdown.item-danger>
                                    </x-dropdown.group>
                                @endcan
                            </x-dropdown>
                        </x-slot>
                    @endif
                </x-table-list.row>
            @empty
                <x-slot name="emptyMessage">
                    <x-empty-state.not-found
                        entity="rank group"
                        :search="$search"
                        :primary-access="gate()->allows('create', $rankGroupClass)"
                    >
                        <x-slot name="primary">
                            <x-button.filled :href="route('ranks.groups.create')" color="primary">
                                Add a rank group
                            </x-button.filled>
                        </x-slot>

                        <x-slot name="secondary">
                            <x-button.filled color="gray" wire:click="$set('search', '')">Clear search</x-button.filled>
                        </x-slot>
                    </x-empty-state.not-found>
                </x-slot>
            @endforelse

            @if (! $reordering && $rankGroups->count() > 0)
                <x-slot name="footer">
                    {{ $rankGroups->withQueryString()->links() }}
                </x-slot>
            @endif
        @endif
    </x-table-list>
</x-panel>
