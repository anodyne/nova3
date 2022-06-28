<x-panel x-data="filtersPanel()" x-bind="parent">
    <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
        <div class="flex-1">
            <x-input.group>
                <x-input.text placeholder="Find users by name, email, or assigned character(s) name..." wire:model="search">
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
                    @icon('filter', 'h-5 w-5')
                    <span>Filters</span>
                    @if ($activeFilterCount > 0)
                        <x-badge color="primary">{{ $activeFilterCount }}</x-badge>
                    @endif
                </div>
            </x-button>
        </div>
    </x-content-box>

    <x-panel.filters x-bind="panel" x-cloak>
        <livewire:livewire-filters-checkbox :filter="$filters['status']" />

        <livewire:livewire-filters-radio :filter="$filters['assigned_characters']" />
    </x-panel.filters>

    <x-table-list columns="5">
        @if ($users->total() > 0)
            <x-slot:header>
                <div class="col-span-2">Name</div>
                <div class="col-span-2">Recent Activity</div>
                <div>Status</div>
            </x-slot:header>
        @endif

        @forelse ($users as $user)
            <x-table-list.row>
                <div class="md:col-span-2">
                    <x-avatar.user :user="$user"></x-avatar.user>
                </div>

                <div class="md:col-span-2">
                    <div class="space-y-2">
                        @if ($user->updated_at !== null)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                @icon('clock', 'shrink-0 mr-1.5 h-5 w-5 text-gray-500')
                                Last activity&nbsp;
                                <time datetime="{{ $user->updated_at }}">
                                    {{ $user->updated_at?->diffForHumans() }}
                                </time>
                            </div>
                        @endif

                        @if ($user->latestLogin !== null)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                @icon('sign-in', 'shrink-0 mr-1.5 h-5 w-5 text-gray-500')
                                Last signed in&nbsp;
                                <time datetime="{{ $user->latestLogin->created_at }}">
                                    {{ $user->latestLogin->created_at?->diffForHumans() }}
                                </time>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center">
                    <x-badge :color="$user->status->color()">
                        {{ $user->status->displayName() }}
                    </x-badge>
                </div>

                <x-slot:controls>
                    <x-dropdown placement="bottom-end">
                        <x-slot:trigger>
                            <x-icon.more class="h-6 w-6" />
                        </x-slot:trigger>

                        <x-dropdown.group>
                            @can('view', $user)
                                <x-dropdown.item :href="route('users.show', $user)" icon="show" data-cy="view">
                                    <span>View</span>
                                </x-dropdown.item>
                            @endcan

                            @can('update', $user)
                                <x-dropdown.item :href="route('users.edit', $user)" icon="edit" data-cy="edit">
                                    <span>Edit</span>
                                </x-dropdown.item>
                            @endcan
                        </x-dropdown.group>

                        @can('activate', $user)
                            <x-dropdown.group>
                                <x-dropdown.item type="submit" id="check-alt" form="activate" data-cy="activate">
                                    <span>Activate</span>

                                    <x-slot:buttonForm>
                                        <x-form :action="route('users.activate', $user)" id="activate" />
                                    </x-slot:buttonForm>
                                </x-dropdown.item>
                            </x-dropdown.group>
                        @endcan

                        @can('deactivate', $user)
                            <x-dropdown.group>
                                <x-dropdown.item type="button" icon="remove" @click="$dispatch('dropdown-toggle');$dispatch('modal-deactivate', {{ json_encode($user) }});" form="deactivate" data-cy="deactivate">
                                    <span>Deactivate</span>
                                </x-dropdown.item>
                            </x-dropdown.group>
                        @endcan

                        @can('delete', $user)
                            <x-dropdown.group>
                                <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($user) }});" data-cy="delete">
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
                    No users found
                </x-search-not-found>
            </x-slot:emptyMessage>
        @endforelse

        <x-slot:footer>
            {{ $users->withQueryString()->links() }}
        </x-slot:footer>
    </x-table-list>
</x-panel>
