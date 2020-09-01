@extends($__novaTemplate)

@section('content')
    <x-page-header title="Roles">
        <x-slot name="controls">
            @can('update', $roles->first())
                <a href="{{ route('roles.index', 'reorder') }}" class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4">
                    @icon('arrow-sort', 'h-6 w-6')
                </a>
            @endcan

            @can('create', 'Nova\Roles\Models\Role')
                <x-button-link :href="route('roles.create')" color="blue" data-cy="create">
                    Add Role
                </x-button-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel x-data="sortableList()" x-init="initSortable()">
        @if ($isReordering)
            <div class="bg-purple-100 border-t border-b border-purple-200 p-4 | sm:rounded-t-md sm:border-t-0">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @icon('arrow-sort', 'h-6 w-6 text-purple-600')
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-purple-900">
                            Change Sorting Order
                        </h3>
                        <div class="mt-2 text-sm text-purple-800">
                            <p>Sorting roles allows for admins to control the hierarchy of roles in the system to ensure that users with a lower role cannot give themselves higher privileges.</p>
                            <p class="mt-4">Top roles have the greatest privileges &ndash; place the most important roles with the highest potential impact higher on the list, to ensure users can't gain unwanted access to areas of Nova.</p>
                        </div>
                        <div class="mt-4">
                            <x-form :action="route('roles.reorder')" id="form-reorder" :divide="false">
                                <input type="hidden" name="sort" x-model="newSortOrder">
                                <div class="flex items-center space-x-4">
                                    <x-button type="submit" form="form-reorder" color="purple">Save Sort Order</x-button>
                                    <a href="{{ route('roles.index') }}" class="text-purple-600 text-sm font-medium transition ease-in-out duration-150 hover:text-purple-800">
                                        Cancel
                                    </a>
                                </div>
                            </x-form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="px-4 py-2 | sm:px-6 sm:py-3">
                <x-search-filter placeholder="Find a role..." :search="$search" />
            </div>
        @endif

        <ul id="sortable-list">
        @forelse ($roles as $role)
            <li class="sortable-item border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out @if ($isReordering) first:border-0 last:rounded-b-md @endif" data-id="{{ $role->id }}">
                <div class="block">
                    <div class="px-4 py-4 flex items-center | sm:px-6">
                        @if ($isReordering)
                            <div class="sortable-handle flex-shrink-0 cursor-move mr-5">
                                @icon('reorder', 'h-5 w-5 text-gray-400')
                            </div>
                        @endif
                        <div class="min-w-0 flex-1 | sm:flex sm:items-center sm:justify-between">
                            <div>
                                <div class="font-medium truncate">
                                    {{ $role->display_name }}
                                </div>
                                <div class="mt-2 flex">
                                    <div class="flex items-center text-sm text-gray-500">
                                        @if ($role->users_count === 1)
                                            @icon('user', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                        @else
                                            @icon('users', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                        @endif
                                        <span>
                                            {{ $role->users_count }} assigned @choice('user|users', $role->users_count)
                                        </span>
                                    </div>
                                    @if ($role->default)
                                        <div class="hidden items-center text-sm text-gray-500 ml-6 | sm:flex">
                                            @icon('check-alt', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                            <span>Assigned to new users</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 flex-shrink-0 | sm:mt-0">
                                <x-avatar-group size="xs" :items="$role->users->take(4)" />
                            </div>
                        </div>
                        <div class="ml-5 flex-shrink-0 leading-0">
                            <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

                                @can('view', $role)
                                    <a href="{{ route('roles.show', $role) }}" class="{{ $component->link() }}" data-cy="view">
                                        @icon('show', $component->icon())
                                        <span>View</span>
                                    </a>
                                @endcan

                                @can('update', $role)
                                    <a href="{{ route('roles.edit', $role) }}" class="{{ $component->link() }}" data-cy="edit">
                                        @icon('edit', $component->icon())
                                        <span>Edit</span>
                                    </a>
                                @endcan

                                @can('duplicate', $role)
                                    <button type="submit" class="{{ $component->link() }}" form="duplicate-{{ $role->id }}" data-cy="duplicate">
                                        @icon('duplicate', $component->icon())
                                        <span>Duplicate</span>
                                    </button>
                                    <x-form :action="route('roles.duplicate', $role)" id="duplicate-{{ $role->id }}" class="hidden" />
                                @endcan

                                @can('delete', $role)
                                    <div class="{{ $component->divider() }}"></div>
                                    <button
                                        x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($role) }});"
                                        class="{{ $component->link() }}"
                                        data-cy="delete"
                                    >
                                        @icon('delete', $component->icon())
                                        <span>Delete</span>
                                    </button>
                                @endcan

                                @if ($role->locked)
                                    <div class="{{ $component->divider() }}"></div>
                                    <div class="{{ $component->text() }}">
                                        This role is locked and cannot be duplicated or deleted.
                                    </div>
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
            <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
                {{ $roles->withQueryString()->links() }}
            </div>
        @endif
    </x-panel>

    <x-tips section="roles" />

    <x-modal color="red" title="Delete Role?" icon="warning" :url="route('roles.delete')">
        <x-slot name="footer">
            <span class="flex w-full | sm:col-start-2">
                <x-button form="form" color="red" :full-width="true">
                    Delete
                </x-button>
            </span>
            <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                <x-button x-on:click="$dispatch('modal-close')" type="button" color="white" :full-width="true">
                    Cancel
                </x-button>
            </span>
        </x-slot>
    </x-modal>
@endsection

@push('scripts')
    <script>
        function sortableList() {
            return {
                newSortOrder: '',
                sortable: null,

                initSortable () {
                    const el = document.getElementById('sortable-list');

                    this.sortable = Sortable.create(el, {
                        draggable: '.sortable-item',
                        handle: '.sortable-handle',
                        onEnd: () => {
                            this.newSortOrder = this.sortable.toArray();
                        }
                    });
                }
            };
        }
    </script>
@endpush
