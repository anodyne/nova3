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
        <div>
            <label for="email" class="sr-only">Find a role</label>
            <div class="flex items-center py-1 text-gray-500 transition duration-150 focus-within:text-gray-700">
                @icon('search', 'mr-3 flex-shrink-0')

                <input
                    autocomplete="off"
                    class="relative w-full appearance-none bg-transparent text-gray-800 focus:outline-none"
                    name="search"
                    type="text"
                    placeholder="Find a role..."
                    data-cy="search-field"
                    role="searchbox"
                >

                {{-- <button
                    v-show="!!value"
                    id="clear-search"
                    class="ml-2 text-gray-400 hover:text-gray-500 transition ease-in-out duration-150"
                    data-cy="search-clear"
                    role="button"
                    aria-label="Reset"
                    @click.prevent="$emit('reset')"
                >
                    <icon
                        name="x"
                        title="Reset"
                        aria-hidden="true"
                    ></icon>
                </button> --}}
            </div>
        </div>
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
                            </div>
                        </div>
                        <div class="mt-4 flex-shrink-0 | sm:mt-0">
                            <x-avatar-group size="xs" :items="$role->users->take(4)" />
                        </div>
                    </div>
                    <div class="ml-5 flex-shrink-0">
                        <dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                            @icon('more', 'h-6 w-6')

                            <template #dropdown="{ toggle }">
                                @can('view', $role)
                                    <a href="{{ route('roles.show', $role) }}" class="dropdown-link" data-cy="view">
                                        @icon('show', 'dropdown-icon')
                                        View
                                    </a>
                                @endcan

                                @can('update', $role)
                                    <a href="{{ route('roles.edit', $role) }}" class="dropdown-link" data-cy="edit">
                                        @icon('edit', 'dropdown-icon')
                                        Edit
                                    </a>
                                @endcan

                                @can('duplicate', $role)
                                    <button class="dropdown-link" data-cy="duplicate">
                                        @icon('duplicate', 'dropdown-icon')
                                        Duplicate
                                    </button>
                                @endcan

                                @can('delete', $role)
                                    <div class="dropdown-divider"></div>
                                    <button
                                        v-on:click="toggle();$emit('open-modal', {{ json_encode($role) }});"
                                        class="dropdown-link"
                                        data-cy="delete"
                                    >
                                        @icon('delete', 'dropdown-icon')
                                        Delete
                                    </button>
                                @endcan

                                @if ($role->locked)
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-text">
                                        This role is locked and cannot be duplicated or deleted.
                                    </div>
                                @endif
                            </template>
                        </dropdown>
                    </div>
                </div>
            </div>
        </li>
    @empty
        <x-search-not-found>
            No roles found
        </x-search-not-found>
    @endforeach
    </ul>

    <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
        {{ $roles->withQueryString()->links() }}
    </div>
</x-panel>

<modal title="Delete role?" color="danger">
    <template #icon>
        @icon('warning', 'h-6 w-6 text-danger-600')
    </template>

    <template #advanced="{ item }">
        <form :action="`roles/${item.id}`" method="POST" role="form" id="form">
            @csrf
            @method('delete')

            Are you sure you want to delete the @{{ item.display_name }} role?
        </form>
    </template>

    <template #footer="{ close }">
        <span class="flex w-full | sm:col-start-2">
            <button form="form" class="button button-danger w-full">
                Delete
            </button>
        </span>
        <span class="mt-3 flex w-full | sm:mt-0 sm:col-start-1">
            <button v-on:click="close" type="button" class="button w-full">
                Cancel
            </button>
        </span>
    </template>
</modal>
@endsection
