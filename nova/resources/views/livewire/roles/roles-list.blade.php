<x-panel x-bind="parent" class="{{ $reordering ? 'overflow-hidden' : '' }}" x-data="filtersPanel()">
    <x-panel.header title="Roles" message="Control what users can do throughout Nova.">
        @if (! $reordering)
            <x-slot:actions>
                @can('update', $roles->first())
                    <x-link tag="button" color="gray" leading="arrow-sort" wire:click="startReordering">
                        Reorder
                    </x-link>
                @endcan

                @can('create', $roleClass)
                    <x-button-filled tag="a" :href="route('roles.create')" data-cy="create" class="order-first md:order-last" leading="add">
                        Add a role
                    </x-button-filled>
                @endcan
            </x-slot:actions>
        @else
            <x-slot:message>
                <x-panel.primary icon="arrow-sort" title="Change sorting order" class="mt-4">
                    <div class="space-y-4">
                        <p>Sorting roles allows for admins to control the hierarchy of roles in the system to ensure that users with a lower role cannot give themselves higher privileges.</p>

                        <p>Top roles have the greatest privileges &ndash; place the most important roles with the highest potential impact higher on the list, to ensure users can't gain unwanted access to areas of Nova.</p>

                        <div>
                            <x-button-filled wire:click="stopReordering">Finish</x-button-filled>
                        </div>
                    </div>
                </x-panel.primary>
            </x-slot:message>
        @endif
    </x-panel.header>

    @if (! $reordering)
        @if ($roleCount === 0)
            <x-empty-state.large
                icon="lock"
                title="Start by creating a role"
                message="Roles allow you to control what users can and cannot access throughout Nova."
                label="Add a role"
                :link="route('roles.create')"
                :link-access="gate()->allows('create', $roleClass)"
            ></x-empty-state.large>
        @else
            <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <div class="flex-1">
                    <x-input.group>
                        <x-input.text placeholder="Find roles by name" wire:model="search">
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
                <livewire:livewire-filters-radio :filter="$filters['default_roles']" />
                <livewire:livewire-filters-radio :filter="$filters['has_permissions']" />
                <livewire:livewire-filters-radio :filter="$filters['has_users']" />
            </x-panel.filters>
        @endif
    @endif

    <x-table-list columns="4" wire:sortable="reorder">
        @if ($roleCount > 0)
            @if ($roles->count() > 0 && ! $reordering)
                <x-slot:header>
                    <div>Name</div>
                    <div># of Users</div>
                    <div>Default Role</div>
                    <div></div>
                </x-slot:header>
            @endif

            @forelse ($roles as $role)
                <x-table-list.row wire:sortable.item="{{ $role->id }}" wire:key="role-{{ $role->id }}">
                    <div class="flex items-center">
                        @if ($reordering)
                            <div class="shrink-0 cursor-move mr-2 md:mr-4" wire:sortable.handle>
                                <x-icon.move-handle class="h-6 w-6 md:h-5 md:w-5 text-gray-500" />
                            </div>
                        @endif

                        <x-table-list.primary-column>
                            {{ $role->display_name }}
                        </x-table-list.primary-column>
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        @if ($role->active_users_count > 0)
                            <div class="flex items-center text-base md:text-sm text-gray-600 dark:text-gray-400">
                                @if ($role->active_users_count === 1)
                                    @icon('user', 'block md:hidden shrink-0 mr-1.5 h-6 w-6 md:h-5 md:w-5 text-gray-500')
                                @else
                                    @icon('users', 'block md:hidden shrink-0 mr-1.5 h-6 w-6 md:h-5 md:w-5 text-gray-500')
                                @endif
                                <span>
                                    {{ $role->active_users_count }} active @choice('user|users', $role->active_users_count)
                                </span>
                            </div>
                        @endif

                        @if ($role->inactive_users_count > 0)
                            <div class="flex items-center text-base md:text-sm text-gray-600 dark:text-gray-400">
                                @if ($role->inactive_users_count === 1)
                                    @icon('user', 'block md:hidden shrink-0 mr-1.5 h-6 w-6 md:h-5 md:w-5 text-gray-500')
                                @else
                                    @icon('users', 'block md:hidden shrink-0 mr-1.5 h-6 w-6 md:h-5 md:w-5 text-gray-500')
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
                            <div class="flex items-center text-base md:text-sm text-gray-600 dark:text-gray-400 space-x-1.5">
                                @icon('check', 'shrink-0 h-6 w-6 text-gray-500 md:text-success-500')
                                <span class="block md:hidden">Assigned to new users</span>
                            </div>
                        @endif
                    </div>

                    <div @class([
                        'flex items-center',
                        'ml-8 md:ml-0' => $reordering
                    ])>
                        <x-avatar-group size="xs" :items="$role->user->take(4)" />
                    </div>

                    @if (! $reordering)
                        <x-slot:actions>
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
                        </x-slot:actions>
                    @endif
                </x-table-list.row>
            @empty
                <x-slot:emptyMessage>
                    <x-empty-state.not-found
                        entity="role"
                        :search="$search"
                        :primary-access="gate()->allows('create', $roleClass)"
                    >
                        <x-slot:primary>
                            <x-button-filled tag="a" :href="route('roles.create')">
                                Add a role
                            </x-button-filled>
                        </x-slot:primary>

                        <x-slot:secondary>
                            <x-button-outline wire:click="$set('search', '')">Clear search</x-button-outline>
                        </x-slot:secondary>
                    </x-empty-state.not-found>
                </x-slot:emptyMessage>
            @endforelse

            @if (! $reordering && $roles->count() > 0)
                <x-slot:footer>
                    {{ $roles->withQueryString()->links() }}
                </x-slot:footer>
            @endif
        @endif
    </x-table-list>
</x-panel>
