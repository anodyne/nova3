@extends($__novaTemplate)

@section('content')
<x-page-header title="Users">
    <x-slot name="controls">
    @can('create', 'Nova\Users\Models\User')
        <a href="{{ route('users.create') }}" class="button button-primary" data-cy="create">
            Add User
        </a>
    @endcan
    </x-slot>
</x-page-header>

<x-panel>
    <div class="px-4 py-2 | sm:px-6 sm:py-3">
        <div>
            <label for="email" class="sr-only">Find a user</label>
            <div class="flex items-center py-1 text-gray-500 transition duration-150 focus-within:text-gray-700">
                @icon('search', 'mr-3 flex-shrink-0')

                <input
                    autocomplete="off"
                    class="relative w-full appearance-none bg-transparent text-gray-800 focus:outline-none"
                    name="search"
                    type="text"
                    placeholder="Find a user..."
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
    @forelse ($users as $user)
        <li class="border-t border-gray-200">
            <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                <div class="flex items-center px-4 py-4 sm:px-6">
                    <div class="min-w-0 flex-1 flex items-center">
                        <div class="flex-shrink-0">
                            <x-avatar :url="$user->avatar_url" />
                        </div>
                        <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                            <div>
                                <div class="leading-normal font-medium truncate">
                                    {{ $user->name }}
                                </div>
                                <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                    @icon('email', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                    <span class="truncate">{{ $user->email }}</span>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div>
                                    <div class="flex items-center text-sm leading-5 text-gray-500">
                                        @icon('clock', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                        Last activity&nbsp;
                                        <time datetime="2020-01-07">January 7, 2020</time>
                                    </div>
                                    @if ($user->last_login != null)
                                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                            @icon('sign-in', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                            Last signed in&nbsp;
                                            <time datetime="{{ $user->last_login }}">{{ $user->last_login }}</time>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                            @icon('more', 'h-6 w-6')

                            <template #dropdown="{ toggle }">
                                @can('view', $user)
                                    <a href="{{ route('users.show', $user) }}" class="dropdown-link" data-cy="view">
                                        @icon('show', 'dropdown-icon')
                                        <span>View</span>
                                    </a>
                                @endcan

                                @can('update', $user)
                                    <a href="{{ route('users.edit', $user) }}" class="dropdown-link" data-cy="edit">
                                        @icon('edit', 'dropdown-icon')
                                        <span>Edit</span>
                                    </a>
                                @endcan

                                @can('delete', $user)
                                    <div class="dropdown-divider"></div>
                                    <button
                                        v-on:click="toggle();$emit('open-modal', {{ json_encode($user) }});"
                                        class="dropdown-link"
                                        data-cy="delete"
                                    >
                                        @icon('delete', 'dropdown-icon')
                                        <span>Delete</span>
                                    </button>
                                @endcan
                            </template>
                        </dropdown>
                    </div>
                </div>
            </div>
        </li>
    @empty
        <x-search-not-found>
            No users found
        </x-search-not-found>
    @endforelse
    </ul>

    <div class="px-4 py-2 border-t border-gray-200 | sm:px-6 sm:py-3">
        {{ $users->withQueryString()->links() }}
    </div>
</x-panel>

<modal title="Delete account?" color="danger">
    <template #icon>
        @icon('warning', 'h-6 w-6 text-danger-600')
    </template>

    <template #advanced="{ item }">
        <form :action="`users/${item.id}`" method="POST" role="form" id="form">
            @csrf
            @method('delete')

            Are you sure you want to delete the account for @{{ item.name }}?
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
