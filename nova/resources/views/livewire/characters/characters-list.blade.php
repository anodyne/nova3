<x-panel x-data="filtersPanel()" x-bind="parent">
    <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
        <div class="flex-1">
            <x-input.group>
                <x-input.text placeholder="Find characters by name or assigned user name/email..." wire:model="search">
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
                    @icon('filter', 'h-5 w-5')
                    <span>Filters</span>
                    @if ($activeFilterCount > 0)
                        <x-badge color="blue" size="xs">{{ $activeFilterCount }}</x-badge>
                    @endif
                </div>
            </x-button>
        </div>
    </x-content-box>

    <x-panel.filters x-bind="panel" x-cloak>
        <livewire:livewire-filters-checkbox :filter="$filters['type']" />

        <livewire:livewire-filters-checkbox :filter="$filters['status']" />

        <livewire:livewire-filters-radio :filter="$filters['assigned_users']" />

        <livewire:livewire-filters-radio :filter="$filters['assigned_positions']" />

        @can('viewAny', 'Nova\Characters\Models\Character')
            <livewire:livewire-filters-checkbox :filter="$filters['my_characters']" />
        @endcan
    </x-panel.filters>

    <x-table-list columns="6">
        @if ($characters->total() > 0)
            <x-slot:header>
                <div class="col-span-3">Name</div>
                <div class="col-span-2">Type</div>
                <div>Status</div>
            </x-slot:header>
        @endif

        @forelse ($characters as $character)
            <x-table-list.row>
                <div class="md:col-span-3 truncate">
                    <x-avatar.character :character="$character"></x-avatar.character>
                </div>

                <div class="flex items-center md:col-span-2">
                    <div class="space-y-2 leading-0">
                        <div>
                            <x-badge size="xs" :color="$character->type->color()">
                                {{ $character->type->displayName() }}
                            </x-badge>
                        </div>

                        @if ($character->users->count() > 0)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                @if ($character->users->count() === 1)
                                    @icon('user', 'shrink-0 mr-1.5 h-5 w-5 text-gray-500')
                                @else
                                    @icon('users', 'shrink-0 mr-1.5 h-5 w-5 text-gray-500')
                                @endif

                                <span class="truncate">
                                    Played by {{ $character->users->implode('name', ' & ') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center">
                    <x-badge size="xs" :color="$character->status->color()">
                        {{ $character->status->displayName() }}
                    </x-badge>
                </div>

                <x-slot:controls>
                    <x-dropdown placement="bottom-end">
                        <x-slot:trigger>
                            <x-icon.more class="h-6 w-6" />
                        </x-slot:trigger>

                        <x-dropdown.group>
                            @can('view', $character)
                                <x-dropdown.item :href="route('characters.show', $character)" icon="show" data-cy="view">
                                    <span>View</span>
                                </x-dropdown.item>
                            @endcan

                            @can('update', $character)
                                <x-dropdown.item :href="route('characters.edit', $character)" icon="edit" data-cy="edit">
                                    <span>Edit</span>
                                </x-dropdown.item>
                            @endcan
                        </x-dropdown.group>

                        @can('activate', $character)
                            <x-dropdown.group>
                                <x-dropdown.item type="submit" id="check-alt" form="activate" data-cy="activate">
                                    <span>Activate</span>

                                    <x-slot:buttonForm>
                                        <x-form :action="route('characters.activate', $character)" id="activate" />
                                    </x-slot:buttonForm>
                                </x-dropdown.item>
                            </x-dropdown.group>
                        @endcan

                        @can('deactivate', $character)
                            <x-dropdown.group>
                                <x-dropdown.item type="button" icon="remove" @click="$dispatch('dropdown-toggle');$dispatch('modal-deactivate', {{ json_encode($character) }});" form="deactivate" data-cy="deactivate">
                                    <span>Deactivate</span>
                                </x-dropdown.item>
                            </x-dropdown.group>
                        @endcan

                        @can('delete', $character)
                            <x-dropdown.group>
                                <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($character) }});" data-cy="delete">
                                    <span>Delete</span>
                                </x-dropdown.item-danger>
                            </x-dropdown.group>
                        @endcan
                    </x-dropdown>
                </x-slot:controls>
            </x-table-list.row>
        @empty
            <x-slot:emptyMessage>
                <x-search-not-found>
                    No characters found
                </x-search-not-found>
            </x-slot:emptyMessage>
        @endforelse

        <x-slot:footer>
            {{ $characters->withQueryString()->links() }}
        </x-slot:footer>
    </x-table-list>
</x-panel>
