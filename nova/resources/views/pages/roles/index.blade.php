@extends($__novaTemplate)

@section('content')
    <x-page-header title="Roles">
        <x-slot name="controls">
            @can('create', 'Nova\Roles\Models\Role')
                <a href="{{ route('roles.create') }}" class="button button-primary" data-cy="create">
                    Add Role
                </a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <div class="px-4 py-2 | sm:px-6 sm:py-3">
            <x-search-filter placeholder="Find a role..." :search="$search" />
        </div>

        <ul>
        @forelse ($roles as $role)
            <li class="border-t border-gray-200">
                <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="px-4 py-4 flex items-center | sm:px-6">
                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <div class="leading-normal font-medium truncate">
                                    {{ $role->display_name }}
                                </div>
                                <div class="mt-2 flex">
                                    <div class="flex items-center text-sm leading-5 text-gray-500">
                                        @icon('users', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                        <span>
                                            {{ $role->users_count }} assigned @choice('user|users', $role->users_count)
                                        </span>
                                    </div>
                                    @if ($role->default)
                                        <div class="hidden items-center text-sm leading-5 text-gray-500 ml-6 | sm:flex">
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
                        <div class="ml-5 flex-shrink-0">
                            <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                @icon('more', 'h-6 w-6')

                                <x-slot name="dropdown">
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
                                        <x-form :action="route('roles.duplicate', $role)" id="duplicate-{{ $role->id }}">
                                            <button type="submit" class="{{ $component->link() }}" form="duplicate-{{ $role->id }}" data-cy="duplicate">
                                                @icon('duplicate', $component->icon())
                                                <span>Duplicate</span>
                                            </button>
                                        </x-form>
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
                                </x-slot>
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

        <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
            {{ $roles->withQueryString()->links() }}
        </div>
    </x-panel>

    <x-modal color="red" headline="Delete role?" icon="warning" :url="route('roles.delete')">
        <x-slot name="footer">
            <span class="flex w-full | sm:col-start-2">
                <button form="form" class="button button-danger w-full">
                    Delete
                </button>
            </span>
            <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
                <button x-on:click="$dispatch('modal-close')" type="button" class="button w-full">
                    Cancel
                </button>
            </span>
        </x-slot>
    </x-modal>
@endsection
