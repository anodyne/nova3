<x-panel x-bind="parent" class="{{ $reordering ? 'overflow-hidden' : '' }}" x-data="filtersPanel()">
    <x-panel.header title="Rank items" message="Combine the rank group, rank name, and rank images to define your game's ranks" :border="$reordering">
        @if (! $reordering)
            <x-slot name="actions">
                @can('update', $rankItems->first())
                    <x-button.text type="button" color="gray" wire:click="startReordering" leading="arrows-sort">Reorder</x-button.text>
                @endcan

                @can('create', $rankItemClass)
                    <x-button.filled :href="route('ranks.items.create')" color="primary" leading="add">Add</x-button.filled>
                @endcan
            </x-slot>
        @else
            <x-slot name="message">
                <x-panel.primary icon="arrows-sort" title="Change sorting order" class="mt-4">
                    <div class="space-y-4">
                        <p>Rank items will appear in the order below whenever they're shown throughout Nova. To change the sorting of rank items, drag them to the desired order. Click Finish to return to the management view.</p>

                        <div>
                            <x-button.filled wire:click="stopReordering">Finish</x-button.filled>
                        </div>
                    </div>
                </x-panel.primary>
            </x-slot>
        @endif
    </x-panel.header>

    @if (! $reordering)
        @if ($rankItemCount === 0)
            <x-empty-state.large icon="layer" title="Start by creating a rank item" message="Rank items bring the rank group, rank name, and images together in a simple and easy-to-use rank experience." label="Add a rank item" :link="route('ranks.items.create')" :link-access="gate()->allows('create', $rankItemClass)"></x-empty-state.large>
        @else
            <x-content-box height="sm" class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-6 md:space-y-0">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find rank items by their rank name" wire:model="search">
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
                    <x-button.text tag="button" :color="$isFiltered ? 'primary' : 'gray'" x-bind="trigger" leading="filter">
                        <span>Filters</span>
                        @if ($activeFilterCount > 0)
                            <x-badge color="primary" size="sm" class="ml-2">{{ $activeFilterCount }}</x-badge>
                        @endif
                    </x-button.text>
                </div>
            </x-content-box>

            <x-panel.filters x-bind="panel" x-cloak>
                <livewire:livewire-filters-select :filter="$filters['group']" />
                <livewire:livewire-filters-select :filter="$filters['name']" />
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
            </x-panel.filters>
        @endif
    @endif

    <x-table-list columns="2" wire:sortable="reorder">
        @if ($rankItemCount > 0)
            @if ($rankItems->count() > 0 && ! $reordering)
                <x-slot name="header">
                    <div>Name</div>
                    <div>Status</div>
                </x-slot>
            @endif

            @forelse ($rankItems as $rankItem)
                <x-table-list.row wire:sortable.item="{{ $rankItem->id }}" wire:key="item-{{ $rankItem->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="mr-2 shrink-0 cursor-move md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 text-gray-500 md:h-5 md:w-5" />
                            </div>
                        @endif

                        <x-table-list.primary-column>
                            <x-rank :rank="$rankItem" />
                            <div class="ml-3">
                                {{ $rankItem->rank_name }}
                            </div>
                        </x-table-list.primary-column>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering,
                    ])>
                        <x-badge :color="$rankItem->status->color()">{{ $rankItem->status->displayName() }}</x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot name="actions">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger">
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot>

                                <x-dropdown.group>
                                    @can('view', $rankItem)
                                        <x-dropdown.item :href="route('ranks.items.show', $rankItem)" icon="show" data-cy="view">
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $rankItem)
                                        <x-dropdown.item :href="route('ranks.items.edit', $rankItem)" icon="edit" data-cy="edit">
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('delete', $rankItem)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger type="button" icon="trash" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($rankItem) }});" data-cy="delete">
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
                    <x-empty-state.not-found entity="rank item" :search="$search" :primary-access="gate()->allows('create', $rankItemClass)">
                        <x-slot name="primary">
                            <x-button.filled :href="route('ranks.items.create')" color="primary">Add a rank item</x-button.filled>
                        </x-slot>

                        <x-slot name="secondary">
                            <x-button.outline color="gray" wire:click="$set('search', '')">Clear search</x-button.outline>
                        </x-slot>
                    </x-empty-state.not-found>
                </x-slot>
            @endforelse

            @if (! $reordering && $rankItems->count() > 0)
                <x-slot name="footer">
                    {{ $rankItems->withQueryString()->links() }}
                </x-slot>
            @endif
        @endif
    </x-table-list>
</x-panel>
