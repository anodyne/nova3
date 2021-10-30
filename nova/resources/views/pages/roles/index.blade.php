@extends($meta->template)

@section('content')
    <x-page-header title="Roles">
        <x-slot name="controls">
            @can('update', $roles->first())
                <x-link :href="route('roles.index', 'reorder')" color="gray-text" size="none">
                    @icon('arrow-sort', 'h-7 w-7 md:h-6 md:w-6')
                </x-link>
            @endcan

            @can('create', 'Nova\Roles\Models\Role')
                <x-link :href="route('roles.create')" color="blue" data-cy="create">
                    Add Role
                </x-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel x-data="sortableList">
        @if ($isReordering)
            <x-content-box class="bg-purple-3 border-t border-b border-purple-6 sm:rounded-t-md sm:border-t-0">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @icon('arrow-sort', 'h-7 w-7 md:h-6 md:w-6 text-purple-9')
                    </div>
                    <div class="ml-3">
                        <h3 class="font-medium text-purple-11">
                            Change Sorting Order
                        </h3>
                        <div class="mt-2 text-base md:text-sm text-purple-11">
                            <p>Sorting roles allows for admins to control the hierarchy of roles in the system to ensure that users with a lower role cannot give themselves higher privileges.</p>
                            <p class="mt-4">Top roles have the greatest privileges &ndash; place the most important roles with the highest potential impact higher on the list, to ensure users can't gain unwanted access to areas of Nova.</p>
                        </div>
                        <div class="mt-4">
                            <x-form :action="route('roles.reorder')" id="form-reorder" :divide="false">
                                <input type="hidden" name="sort" x-model="newSortOrder">
                                <div class="flex items-center space-x-4">
                                    <x-button type="submit" form="form-reorder" color="purple">Save Sort Order</x-button>
                                    <x-link :href="route('roles.index')" color="purple-text" size="none">
                                        Cancel
                                    </x-link>
                                </div>
                            </x-form>
                        </div>
                    </div>
                </div>
            </x-content-box>
        @else
            <x-content-box height="xs">
                <x-search-filter placeholder="Find a role..." :search="$search" />
            </x-content-box>
        @endif

        <ul id="sortable-list">
            @forelse ($roles as $role)
                <li class="sortable-item border-t border-gray-6 hover:bg-gray-2 transition ease-in-out duration-200 @if ($isReordering) first:border-0 last:rounded-b-md @endif" data-id="{{ $role->id }}">
                    <div class="block">
                        <div class="px-4 py-4 flex items-center sm:px-6">
                            @if ($isReordering)
                                <div class="sortable-handle flex-shrink-0 cursor-move mr-5">
                                    <x-icon.move-handle class="h-5 w-5 text-gray-9" />
                                </div>
                            @endif
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <div class="font-medium truncate">
                                        {{ $role->display_name }}
                                    </div>
                                    <div class="mt-2 flex flex-col space-y-2 sm:flex-row sm:space-x-6 sm:space-y-0">
                                        @if ($role->active_users_count > 0)
                                            <div class="flex items-center text-sm text-gray-11">
                                                @if ($role->active_users_count === 1)
                                                    @icon('user', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                @else
                                                    @icon('users', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                @endif
                                                <span>
                                                    {{ $role->active_users_count }} active @choice('user|users', $role->active_users_count)
                                                </span>
                                            </div>
                                        @endif

                                        @if ($role->inactive_users_count > 0)
                                            <div class="flex items-center text-sm text-gray-11">
                                                @if ($role->inactive_users_count === 1)
                                                    @icon('user', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                @else
                                                    @icon('users', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                @endif
                                                <span>
                                                    {{ $role->inactive_users_count }} inactive @choice('user|users', $role->inactive_users_count)
                                                </span>
                                            </div>
                                        @endif

                                        @if ($role->default)
                                            <div class="flex items-center text-sm text-gray-11">
                                                @icon('check', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                <span>Assigned to new users</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 flex-shrink-0 sm:mt-0">
                                    <x-avatar-group size="xs" :items="$role->users->take(4)" />
                                </div>
                            </div>
                            <div class="ml-5 flex-shrink-0 leading-0">
                                <x-dropdown placement="bottom-end">
                                    <x-slot name="trigger">
                                        <x-icon.more class="h-6 w-6" />
                                    </x-slot>

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

                                                <x-slot name="buttonForm">
                                                    <x-form :action="route('roles.duplicate', $role)" id="duplicate-{{ $role->id }}" class="hidden" />
                                                </x-slot>
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
                        </div>
                    </div>
                </li>
            @empty
                <x-search-not-found>
                    No roles found
                </x-search-not-found>
            @endforelse
        </ul>

        @if (! $isReordering)
            <div class="px-4 py-2 border-t border-gray-6 sm:px-6 sm:py-3">
                {{ $roles->withQueryString()->links() }}
            </div>
        @endif
    </x-panel>

    <x-tips section="roles" />

    <x-modal color="red" title="Delete Role?" icon="warning" :url="route('roles.delete')">
        <x-slot name="footer">
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form" color="red" full-width>
                    Delete
                </x-button>
            </span>
            <span class="mt-3 flex w-full sm:mt-0 sm:col-start-1">
                <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                    Cancel
                </x-button>
            </span>
        </x-slot>
    </x-modal>
@endsection
