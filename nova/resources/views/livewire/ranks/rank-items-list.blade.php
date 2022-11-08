<x-panel x-bind="parent" class="{{ $reordering ? 'overflow-hidden' : '' }}" x-data="filtersPanel()">
    <x-panel.header title="Rank items" message="Bring the rank group, rank name, and images together in a simple and easy-to-use rank experience.">
        @if (! $reordering)
            <x-slot:controls>
                @can('update', $rankItems->first())
                    <x-button type="button" size="none" color="gray-text" wire:click="startReordering" leading="arrow-sort">
                        Reorder
                    </x-button>
                @endcan

                @can('create', $rankItemClass)
                    <x-link :href="route('ranks.items.create')" color="primary" data-cy="create" leading="add">
                        Add rank item
                    </x-link>
                @endcan
            </x-slot:controls>
        @else
            <x-slot:message>
                <x-panel.info icon="arrow-sort" title="Change sorting order" class="mt-4">
                    <div class="space-y-4">
                        <p>Rank items will appear in the order below whenever they're shown throughout Nova. To change the sorting of rank items, drag them to the desired order. Click Finish to return to the management view.</p>

                        <div>
                            <x-button type="button" wire:click="stopReordering" color="info">Finish</x-button>
                        </div>
                    </div>
                </x-panel.info>
            </x-slot:message>
        @endif
    </x-panel.header>

    @if (! $reordering)
        @if ($rankItemCount === 0)
            <x-empty-state.large
                icon="layer"
                title="Start by creating a rank item"
                message="Rank items bring the rank group, rank name, and images together in a simple and easy-to-use rank experience."
                label="Add rank item"
                :link="route('ranks.items.create')"
                :link-access="gate()->allows('create', $rankItemClass)"
            ></x-empty-state.large>
        @else
            <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find rank item(s) by their rank name" wire:model="search">
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
                <livewire:livewire-filters-select :filter="$filters['group']" />
                <livewire:livewire-filters-select :filter="$filters['name']" />
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
            </x-panel.filters>
        @endif
    @endif

    <x-table-list columns="2" wire:sortable="reorder">
        @if ($rankItemCount > 0)
            @if ($rankItems->count() > 0 && ! $reordering)
                <x-slot:header>
                    <div>Name</div>
                    <div>Status</div>
                </x-slot:header>
            @endif

            @forelse ($rankItems as $rankItem)
                <x-table-list.row wire:sortable.item="{{ $rankItem->id }}" wire:key="item-{{ $rankItem->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="shrink-0 cursor-move mr-2 md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 md:h-5 md:w-5 text-gray-500" />
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
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <x-badge :color="$rankItem->status->color()">{{ $rankItem->status->displayName() }}</x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot:controls>
                            <x-dropdown placement="bottom-end">
                                <x-slot:trigger>
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot:trigger>

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
                                        <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($rankItem) }});" data-cy="delete">
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
                    <x-empty-state.not-found
                        entity="rank item"
                        :search="$search"
                        :primary-access="gate()->allows('create', $rankItemClass)"
                    >
                        <x-slot:primary>
                            <x-link :href="route('ranks.items.create')" color="primary">
                                Add rank item
                            </x-link>
                        </x-slot:primary>

                        <x-slot:secondary>
                            <x-button wire:click="$set('search', '')">Clear search</x-button>
                        </x-slot:secondary>
                    </x-empty-state.not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if (! $reordering && $rankItems->count() > 0)
                <x-slot:footer>
                    {{ $rankItems->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        @endif
    </x-table-list>
</x-panel>
