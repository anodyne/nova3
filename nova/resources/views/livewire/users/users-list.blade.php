<x-panel x-data="filtersPanel()" x-bind="parent">
    <x-panel.header title="Users" message="Manage all of the game's users" :border="false">
        <x-slot name="actions">
            @if ($users->count() > 0)
                @can('create', $userClass)
                    <x-button.filled :href="route('users.create')" leading="add">Add</x-button.filled>
                @endcan
            @endif
        </x-slot>
    </x-panel.header>

    @if ($userCount === 0)
        <x-empty-state.large icon="list" title="Start by creating a user" message="Departments allow you to organize character positions into logical groups that you can display on your manifests." label="Add a user" :link="route('users.create')" :link-access="gate()->allows('create', $userClass)"></x-empty-state.large>
    @else
        <x-content-box height="sm" class="flex flex-col space-y-4 md:flex-row md:items-center md:space-x-6 md:space-y-0">
            <div class="flex-1">
                <x-input.group>
                    <x-input.text placeholder="Find users by name, email, or assigned character(s) name" wire:model="search">
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
            <livewire:livewire-filters-radio :filter="$filters['assigned_characters']" />
        </x-panel.filters>
    @endif

    <x-table-list columns="5">
        @if ($userCount > 0)
            @if ($users->total() > 0)
                <x-slot name="header">
                    <div class="col-span-2">Name</div>
                    <div class="col-span-2">Recent Activity</div>
                    <div>Status</div>
                </x-slot>
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
                                    <x-icon name="clock" size="sm" class="mr-1.5 shrink-0 text-gray-500"></x-icon>
                                    Last activity&nbsp;
                                    <time datetime="{{ $user->updated_at }}">
                                        {{ $user->updated_at?->diffForHumans() }}
                                    </time>
                                </div>
                            @endif

                            @if ($user->latestLogin !== null)
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <x-icon name="login" size="sm" class="mr-1.5 shrink-0 text-gray-500"></x-icon>
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

                    <x-slot name="actions">
                        <x-dropdown placement="bottom-end">
                            <x-slot name="trigger">
                                <x-icon.more class="h-6 w-6" />
                            </x-slot>

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

                                        <x-slot name="buttonForm">
                                            <x-form :action="route('users.activate', $user)" id="activate" />
                                        </x-slot>
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            @endcan

                            @can('deactivate', $user)
                                <x-dropdown.group>
                                    <x-dropdown.item type="button" icon="remove" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-deactivate', {{ json_encode($user) }});" form="deactivate" data-cy="deactivate">
                                        <span>Deactivate</span>
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            @endcan

                            @can('delete', $user)
                                <x-dropdown.group>
                                    <x-dropdown.item-danger type="button" icon="trash" x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($user) }});" data-cy="delete">
                                        <span>Delete</span>
                                    </x-dropdown.item-danger>
                                </x-dropdown.group>
                            @endcan
                        </x-dropdown>
                    </x-slot>
                </x-table-list.row>
            @empty
                <x-slot name="emptyMessage">
                    <x-empty-state.not-found entity="user" :search="$search" :primary-access="gate()->allows('create', $userClass)">
                        <x-slot name="primary">
                            <x-button.filled :href="route('users.create')" color="primary">Add a user</x-button.filled>
                        </x-slot>

                        <x-slot name="secondary">
                            <x-button.outline wire:click="$set('search', '')" color="gray">Clear search</x-button.outline>
                        </x-slot>
                    </x-empty-state.not-found>
                </x-slot>
            @endforelse

            @if ($users->count() > 0)
                <x-slot name="footer">
                    {{ $users->withQueryString()->links() }}
                </x-slot>
            @endif
        @endif
    </x-table-list>
</x-panel>
