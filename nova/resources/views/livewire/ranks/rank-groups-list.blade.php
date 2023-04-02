<x-panel x-data="filtersPanel()" class="{{ $reordering ? 'overflow-hidden' : '' }}">
    <x-panel.header title="Rank groups" message="Collections of related rank items for simpler searching and selecting.">
        @if (! $reordering)
            <x-slot:actions>
                @can('update', $rankGroups->first())
                    <x-button type="button" size="none" color="gray-text" wire:click="startReordering" leading="arrow-sort">
                        Reorder
                    </x-button>
                @endcan

                @can('create', $rankGroupClass)
                    <x-link :href="route('ranks.groups.create')" color="primary" data-cy="create" leading="add">
                        Add a rank group
                    </x-link>
                @endcan
            </x-slot:actions>
        @else
            <x-slot:message>
                <x-panel.primary icon="arrow-sort" title="Change sorting order" class="mt-4">
                    <div class="space-y-4">
                        <p>Rank groups will appear in the order below whenever they're shown throughout Nova. To change the sorting of rank groups, drag them to the desired order. Click Finish to return to the management view.</p>

                        <div>
                            <x-button-filled wire:click="stopReordering">Finish</x-button-filled>
                        </div>
                    </div>
                </x-panel.primary>
            </x-slot:message>
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
            <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find rank groups by name" wire:model="search">
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
                <livewire:livewire-filters-checkbox :filter="$filters['status']" />
                <livewire:livewire-filters-radio :filter="$filters['rank_count']" />
            </x-panel.filters>
        @endif
    @endif

    <x-table-list columns="3" wire:sortable="reorder">
        @if ($rankGroupCount > 0)
            @if ($rankGroups->count() > 0 && ! $reordering)
                <x-slot:header>
                    <div>Name</div>
                    <div class="text-center"># of Ranks</div>
                    <div>Status</div>
                </x-slot:header>
            @endif

            @forelse ($rankGroups as $rankGroup)
                <x-table-list.row wire:sortable.item="{{ $rankGroup->id }}" wire:key="group-{{ $rankGroup->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="shrink-0 cursor-move mr-2 md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 md:h-5 md:w-5 text-gray-500" />
                            </div>
                        @endif

                        <x-table-list.primary-column>
                            {{ $rankGroup->name }}
                        </x-table-list.primary-column>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <div class="w-full text-base md:text-center text-gray-600 dark:text-gray-400">
                            {{ $rankGroup->ranks_count }} <span class="inline md:hidden">@choice('rank item|rank items', $rankGroup->ranks_count)</span>
                        </div>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <x-badge :color="$rankGroup->status->color()">{{ $rankGroup->status->displayName() }}</x-badge>
                    </div>

                    @if (! $reordering)
                        <x-slot:actions>
                            <x-dropdown placement="bottom-end">
                                <x-slot:trigger>
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot:trigger>

                                <x-dropdown.group>
                                    @can('view', $rankGroup)
                                        <x-dropdown.item :href="route('ranks.groups.show', $rankGroup)" icon="show" data-cy="view">
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $rankGroup)
                                        <x-dropdown.item :href="route('ranks.groups.edit', $rankGroup)" icon="edit" data-cy="edit">
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('duplicate', $rankGroup)
                                        <x-dropdown.item type="submit" icon="copy" @click="$dispatch('dropdown-toggle');$dispatch('modal-duplicate', {{ json_encode($rankGroup) }});" data-cy="duplicate">
                                            <span>Duplicate</span>

                                            <x-slot:buttonForm>
                                                <x-form :action="route('ranks.groups.duplicate', $rankGroup)" id="duplicate-{{ $rankGroup->id }}" class="hidden" />
                                            </x-slot:buttonForm>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('delete', $rankGroup)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($rankGroup) }});" data-cy="delete">
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
                        entity="rank group"
                        :search="$search"
                        :primary-access="gate()->allows('create', $rankGroupClass)"
                    >
                        <x-slot:primary>
                            <x-link :href="route('ranks.groups.create')" color="primary">
                                Add a rank group
                            </x-link>
                        </x-slot:primary>

                        <x-slot:secondary>
                            <x-button wire:click="$set('search', '')">Clear search</x-button>
                        </x-slot:secondary>
                    </x-empty-state.not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if (! $reordering && $rankGroups->count() > 0)
                <x-slot:footer>
                    {{ $rankGroups->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        @endif
    </x-table-list>
</x-panel>
