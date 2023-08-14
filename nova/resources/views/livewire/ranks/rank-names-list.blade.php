<x-panel class="{{ $reordering ? 'overflow-hidden' : '' }}" x-data="filtersPanel()">
    <x-panel.header title="Rank names" message="Re-use basic rank information across all of your rank items" :border="$reordering">
        @if (! $reordering)
            <x-slot name="actions">
                @can('update', $rankNames->first())
                    <x-button.text type="button" color="gray" wire:click="startReordering" leading="arrows-sort">Reorder</x-button.text>
                @endcan

                @can('create', $rankNameClass)
                    <x-button.filled :href="route('ranks.names.create')" color="primary" leading="add">Add</x-button.filled>
                @endcan
            </x-slot>
        @else
            <x-slot name="message">
                <x-panel.primary icon="arrows-sort" title="Change sorting order" class="mt-4">
                    <div class="space-y-4">
                        <p>Rank names will appear in the order below whenever they're shown throughout Nova. To change the sorting of rank names, drag them to the desired order. Click Finish to return to the management view.</p>

                        <div>
                            <x-button.filled wire:click="stopReordering">Finish</x-button.filled>
                        </div>
                    </div>
                </x-panel.primary>
            </x-slot>
        @endif
    </x-panel.header>

    @if (! $reordering)
        @if ($rankNameCount === 0)
            <x-empty-state.large icon="layer" title="Start by creating a rank name" message="Rank names eliminate the repetitive task of setting the name of a rank by letting you re-use names across all of your rank items." label="Add a rank name" :link="route('ranks.names.create')" :link-access="gate()->allows('create', $rankNameClass)"></x-empty-state.large>
        @else
            <x-content-box height="sm" class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-6 md:space-y-0">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find rank names by name" wire:model="search">
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
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
                <livewire:livewire-filters-radio :filter="$filters['rank_count']" />
            </x-panel.filters>
        @endif
    @endif

    <x-table-list columns="3" wire:sortable="reorder">
        @if ($rankNameCount > 0)
            @if ($rankNames->count() > 0 && ! $reordering)
                <x-slot name="header">
                    <div>Name</div>
                    <div class="text-center"># of Ranks</div>
                    <div>Status</div>
                </x-slot>
            @endif

            @forelse ($rankNames as $rankName)
                <x-table-list.row wire:sortable.item="{{ $rankName->id }}" wire:key="name-{{ $rankName->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="mr-2 shrink-0 cursor-move md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 text-gray-500 md:h-5 md:w-5" />
                            </div>
                        @endif

                        <x-table-list.primary-column>
                            {{ $rankName->name }}
                        </x-table-list.primary-column>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering,
                    ])>
                        <div class="w-full text-base text-gray-600 dark:text-gray-400 md:text-center">
                            {{ $rankName->ranks_count }}
                            <span class="inline md:hidden">@choice('rank item|rank items', $rankName->ranks_count)</span>
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering,
                    ])>
                        <x-badge :color="$rankName->status->color()">{{ $rankName->status->displayName() }}</x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot name="actions">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger">
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot>

                                <x-dropdown.group>
                                    @can('view', $rankName)
                                        <x-dropdown.item :href="route('ranks.names.show', $rankName)" icon="show" data-cy="view">
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $rankName)
                                        <x-dropdown.item :href="route('ranks.names.edit', $rankName)" icon="edit" data-cy="edit">
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('duplicate', $rankName)
                                        <x-dropdown.item type="submit" icon="copy" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($rankName) }});" data-cy="duplicate">
                                            <span>Duplicate</span>

                                            <x-slot name="buttonForm">
                                                <x-form :action="route('ranks.names.duplicate', $rankName)" id="duplicate-{{ $rankName->id }}" class="hidden" />
                                            </x-slot>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('delete', $rankName)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger type="button" icon="trash" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($rankName) }});" data-cy="delete">
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
                    <x-empty-state.not-found entity="rank name" :search="$search" :primary-access="gate()->allows('create', $rankNameClass)">
                        <x-slot name="primary">
                            <x-button.filled :href="route('ranks.names.create')" color="primary">Add a rank name</x-button.filled>
                        </x-slot>

                        <x-slot name="secondary">
                            <x-button.filled color="gray" wire:click="$set('search', '')">Clear search</x-button.filled>
                        </x-slot>
                    </x-empty-state.not-found>
                </x-slot>
            @endforelse

            @if (! $reordering && $rankNames->count() > 0)
                <x-slot name="footer">
                    {{ $rankNames->withQueryString()->links() }}
                </x-slot>
            @endif
        @endif
    </x-table-list>
</x-panel>
