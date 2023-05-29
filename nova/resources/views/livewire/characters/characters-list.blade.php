<x-panel x-data="filtersPanel()" x-bind="parent">
    <x-panel.header title="Characters" message="Manage all of the game's characters" :border="false">
        <x-slot:actions>
            @can('createAny', $characterClass)
                <x-button.filled :href="route('characters.create')" leading="add">
                    Add
                </x-button.filled>
            @endcan
        </x-slot:actions>
    </x-panel.header>

    @if ($characterCount === 0)
        <x-empty-state.large
            icon="list"
            title="Start by creating a character"
            message="Departments allow you to organize character positions into logical groups that you can display on your manifests."
            label="Add a character"
            :link="route('characters.create')"
            :link-access="gate()->allows('createAny', $characterClass)"
        ></x-empty-state.large>
    @else
        <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
            <div class="flex-1">
                <x-input.group>
                    <x-input.text placeholder="Find characters by name or assigned user name/email" wire:model="search">
                        <x-slot:leadingAddOn>
                            <x-icon name="search" size="sm"></x-icon>
                        </x-slot:leadingAddOn>

                        @if ($search)
                            <x-slot:trailingAddOn>
                                <x-button.text tag="button" color="gray" wire:click="$set('search', '')">
                                    <x-icon name="dismiss" size="sm"></x-icon>
                                </x-button.text>
                            </x-slot:trailingAddOn>
                        @endif
                    </x-input.text>
                </x-input.group>
            </div>

            <div class="shrink flex justify-between md:justify-start items-center space-x-4">
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
            <livewire:livewire-filters-checkbox :filter="$filters['type']" />
            <livewire:livewire-filters-checkbox :filter="$filters['status']" />
            <livewire:livewire-filters-radio :filter="$filters['assigned_users']" />
            <livewire:livewire-filters-radio :filter="$filters['assigned_positions']" />

            @can('viewAny', $characterClass)
                <livewire:livewire-filters-checkbox :filter="$filters['my_characters']" />
            @endcan
        </x-panel.filters>
    @endif

    <x-table-list columns="6">
        @if ($characterCount > 0)
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
                                <x-badge :color="$character->type->color()">
                                    {{ $character->type->displayName() }}
                                </x-badge>
                            </div>

                            @if ($character->users->count() > 0)
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    @if ($character->users->count() === 1)
                                        <x-icon name="user" size="sm" class="shrink-0 mr-1.5 text-gray-500"></x-icon>
                                    @else
                                        <x-icon name="users" size="sm" class="shrink-0 mr-1.5 text-gray-500"></x-icon>
                                    @endif

                                    <span class="truncate">
                                        Played by {{ $character->users->implode('name', ' & ') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center">
                        <x-badge :color="$character->status->color()">
                            {{ $character->status->displayName() }}
                        </x-badge>
                    </div>

                    <x-slot:actions>
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
                                    <x-dropdown.item-danger type="button" icon="trash" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($character) }});" data-cy="delete">
                                        <span>Delete</span>
                                    </x-dropdown.item-danger>
                                </x-dropdown.group>
                            @endcan
                        </x-dropdown>
                    </x-slot:actions>
                </x-table-list.row>
            @empty
                <x-slot:emptyMessage>
                    <x-empty-state.not-found
                        entity="character"
                        :search="$search"
                        :primary-access="gate()->allows('createAny', $characterClass)"
                    >
                        <x-slot:primary>
                            <x-button.filled :href="route('characters.create')" color="primary">
                                Add a character
                            </x-button.filled>
                        </x-slot:primary>

                        <x-slot:secondary>
                            <x-button.outline color="gray" wire:click="$set('search', '')">Clear search</x-button.outline>
                        </x-slot:secondary>
                    </x-empty-state.not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if ($characters->count() > 0)
                <x-slot:footer>
                    {{ $characters->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        @endif
    </x-table-list>
</x-panel>
