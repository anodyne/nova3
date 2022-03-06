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
                            <p>Sorting roles allows for admins to control the hierarchy of roles in the system to ensure that users with a lower role cannot give themselves higher privileges.</p>

                            <p class="mt-4">Top roles have the greatest privileges &ndash; place the most important roles with the highest potential impact higher on the list, to ensure users can't gain unwanted access to areas of Nova.</p>
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
                        <x-input.text placeholder="Find role..." wire:model="search">
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

                    @can('update', $roles->first())
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
                <livewire:livewire-filters-radio :filter="$filters['default_roles']" />
                <livewire:livewire-filters-radio :filter="$filters['has_permissions']" />
                <livewire:livewire-filters-radio :filter="$filters['has_users']" />
            </x-panel.filters>
        @endif

        <ul class="divide-y divide-gray-6" wire:sortable="reorder">
            @if ($roles->count() > 0 && ! $reordering)
                <li class="hidden md:block border-t border-gray-6 bg-gray-2 text-xs leading-4 font-semibold text-gray-9 uppercase tracking-wider">
                    <div class="block">
                        <x-content-box height="xs" class="flex">
                            <div class="min-w-0 flex-1 grid grid-cols-4 gap-4">
                                <div>Name</div>
                                <div># of Users</div>
                                <div>Default Role</div>
                                <div></div>
                            </div>
                            <div class="block ml-4 w-6"></div>
                        </x-content-box>
                    </div>
                </li>
            @endif

            @forelse ($roles as $role)
                <li wire:sortable.item="{{ $role->id }}" wire:key="department-{{ $role->id }}">
                    <div class="block hover:bg-gray-2 focus:outline-none focus:bg-gray-2 transition duration-200 ease-in-out">
                        <x-content-box height="sm" class="flex">
                            <div class="min-w-0 flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="flex items-center">
                                    @if ($reordering)
                                        <div class="shrink-0 cursor-move mr-2 md:mr-4" wire:sortable.handle>
                                            <x-icon.move-handle class="h-6 w-6 md:h-5 md:w-5 text-gray-9" />
                                        </div>
                                    @endif

                                    <div class="font-medium truncate">
                                        {{ $role->display_name }}
                                    </div>
                                </div>

                                <div @class([
                                    'flex items-center',
                                    'ml-8 md:ml-0' => $reordering
                                ])>
                                    @if ($role->active_users_count > 0)
                                        <div class="flex items-center text-base md:text-sm text-gray-11">
                                            @if ($role->active_users_count === 1)
                                                @icon('user', 'block md:hidden shrink-0 mr-1.5 h-6 w-6 md:h-5 md:w-5 text-gray-9')
                                            @else
                                                @icon('users', 'block md:hidden shrink-0 mr-1.5 h-6 w-6 md:h-5 md:w-5 text-gray-9')
                                            @endif
                                            <span>
                                                {{ $role->active_users_count }} active @choice('user|users', $role->active_users_count)
                                            </span>
                                        </div>
                                    @endif

                                    @if ($role->inactive_users_count > 0)
                                        <div class="flex items-center text-base md:text-sm text-gray-11">
                                            @if ($role->inactive_users_count === 1)
                                                @icon('user', 'block md:hidden shrink-0 mr-1.5 h-6 w-6 md:h-5 md:w-5 text-gray-9')
                                            @else
                                                @icon('users', 'block md:hidden shrink-0 mr-1.5 h-6 w-6 md:h-5 md:w-5 text-gray-9')
                                            @endif
                                            <span>
                                                {{ $role->inactive_users_count }} inactive @choice('user|users', $role->inactive_users_count)
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div @class([
                                    'flex items-center',
                                    'ml-8 md:ml-0' => $reordering
                                ])>
                                    @if ($role->default)
                                        <div class="flex items-center text-base md:text-sm text-gray-11 space-x-1.5">
                                            @icon('check', 'shrink-0 h-6 w-6 text-gray-9 md:text-green-9')
                                            <span class="block md:hidden">Assigned to new users</span>
                                        </div>
                                    @endif
                                </div>

                                <div @class([
                                    'flex items-center',
                                    'ml-8 md:ml-0' => $reordering
                                ])>
                                    <x-avatar-group size="xs" :items="$role->users->take(4)" />
                                </div>
                            </div>

                            @if (! $reordering)
                                <div class="ml-4 flex md:items-center">
                                    <x-dropdown placement="bottom-end">
                                        <x-slot:trigger>
                                            <x-icon.more class="h-6 w-6" />
                                        </x-slot:trigger>

                                        <x-dropdown.group>
                                            @can('view', $role)
                                                <x-dropdown.item :href="route('roles.show', $role)" icon="show" data-cy="view">
                                                    <span>View</span>
                                                </x-dropdown.item>
                                            @endcan

                                            @can('update', $role)
                                                <x-dropdown.item :href="route('roles.edit', $role)" icon="edit" data-cy="edit">
                                                    <span>Edit</span>
                                                </x-dropdown.item>
                                            @endcan

                                            @can('duplicate', $role)
                                                <x-dropdown.item type="submit" form="duplicate-{{ $role->id }}" icon="copy" data-cy="duplicate">
                                                    <span>Duplicate</span>

                                                    <x-slot:buttonForm>
                                                        <x-form :action="route('roles.duplicate', $role)" id="duplicate-{{ $role->id }}" class="hidden" />
                                                    </x-slot:buttonForm>
                                                </x-dropdown.item>
                                            @endcan
                                        </x-dropdown.group>

                                        @can('delete', $role)
                                            <x-dropdown.group>
                                                <x-dropdown.item-danger type="button" icon="delete" data-cy="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($role) }});">
                                                    <span>Delete</span>
                                                </x-dropdown.item-danger>
                                            </x-dropdown.group>
                                        @endcan

                                        @if ($role->locked)
                                            <x-dropdown.group>
                                                <x-dropdown.text>
                                                    This role is locked and cannot be duplicated or deleted.
                                                </x-dropdown.text>
                                            </x-dropdown.group>
                                        @endif
                                    </x-dropdown>
                                </div>
                            @endif
                        </x-content-box>
                    </div>
                </li>
            @empty
                <li class="border-t border-gray-6">
                    <x-search-not-found>
                        No roles found
                    </x-search-not-found>
                </li>
            @endforelse
        </ul>

        @if (! $reordering)
            <x-content-box height="xs" class="border-t border-gray-6">
                {{ $roles->withQueryString()->links() }}
            </x-content-box>
        @endif
    </x-panel>
</div>