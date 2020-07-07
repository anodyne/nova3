@extends($__novaTemplate)

@section('content')
    <x-page-header>
        <x-slot name="title">
            @if (request()->has('status'))
                {{ ucfirst(request()->status) }}
            @endif
            Users
        </x-slot>

        <x-slot name="controls">
            @can('create', 'Nova\Users\Models\User')
                <a href="{{ route('users.create') }}" class="button button-primary" data-cy="create">
                    Add User
                </a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <div>
            <div class="p-4 | sm:hidden">
                <select x-on:change="window.location.replace($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150">
                    <option value="{{ route('users.index', 'status=active') }}"{{ request()->status === 'active' ? 'selected' : '' }}>Active Users</option>
                    <option value="{{ route('users.index', 'status=pending') }}"{{ request()->status === 'pending' ? 'selected' : '' }}>Pending Users</option>
                    <option value="{{ route('users.index', 'status=inactive') }}"{{ request()->status === 'inactive' ? 'selected' : '' }}>Inactive Users</option>
                    <option value="{{ route('users.index') }}"{{ !request()->has('status') ? 'selected' : '' }}>All Users</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 px-4 | sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            href="{{ route('users.index', 'status=active') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none @if (request()->status === 'active') border-blue-500 text-blue-600 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Active
                        </a>
                        <a
                            href="{{ route('users.index', 'status=pending') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none @if (request()->status === 'pending') border-blue-500 text-blue-600 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Pending
                        </a>
                        <a
                            href="{{ route('users.index', 'status=inactive') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none @if (request()->status === 'inactive') border-blue-500 text-blue-600 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Inactive
                        </a>
                        <a
                            href="{{ route('users.index') }}"
                            class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none @if (!request()->has('status')) border-blue-500 text-blue-600 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            All Users
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="px-4 py-2 | sm:px-6 sm:py-3">
            <x-search-filter placeholder="Find a user..." :search="$search" />
        </div>

        <ul>
        @forelse ($users as $user)
            <li class="border-t border-gray-200">
                <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                    <div class="flex items-center px-4 py-4 | sm:px-6">
                        <div class="min-w-0 flex-1 flex items-center">
                            <div class="flex-shrink-0">
                                <x-avatar :url="$user->avatar_url" />
                            </div>
                            <div class="min-w-0 flex-1 px-4 | md:grid md:grid-cols-2 md:gap-4">
                                <div>
                                    <div class="leading-normal font-medium truncate">
                                        {{ $user->name }}
                                    </div>
                                    <div class="mt-1">
                                        <x-badge size="sm" :type="$user->status->color()">
                                            {{ $user->status->displayName() }}
                                        </x-badge>
                                    </div>
                                </div>
                                <div class="hidden md:block">
                                    <div>
                                        <div class="flex items-center text-sm leading-5 text-gray-500">
                                            @icon('clock', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                            Last activity&nbsp;
                                            <time datetime="{{ $user->updated_at }}">
                                                {{ $user->updated_at->diffForHumans() }}
                                            </time>
                                        </div>
                                        @if ($user->last_login_at != null)
                                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                @icon('sign-in', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400')
                                                Last signed in&nbsp;
                                                <time datetime="{{ $user->last_login_at }}">
                                                    {{ $user->last_login_at->diffForHumans() }}
                                                </time>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <x-dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                @icon('more', 'h-6 w-6')

                                <x-slot name="dropdown">
                                    @can('view', $user)
                                        <a href="{{ route('users.show', $user) }}" class="{{ $component->link() }}" data-cy="view">
                                            @icon('show', $component->icon())
                                            <span>View</span>
                                        </a>
                                    @endcan

                                    @can('update', $user)
                                        <a href="{{ route('users.edit', $user) }}" class="{{ $component->link() }}" data-cy="edit">
                                            @icon('edit', $component->icon())
                                            <span>Edit</span>
                                        </a>
                                    @endcan

                                    @can('activate', $user)
                                        <div class="{{ $component->divider() }}"></div>
                                        <x-form :action="route('users.activate', $user)" id="activate"></x-form>
                                        <button
                                            type="submit"
                                            form="activate"
                                            class="{{ $component->link() }}"
                                            data-cy="activate"
                                        >
                                            @icon('check-alt', $component->icon())
                                            <span>Activate</span>
                                        </button>
                                    @endcan

                                    @can('deactivate', $user)
                                        <div class="{{ $component->divider() }}"></div>
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-deactivate', {{ json_encode($user) }});"
                                            type="button"
                                            form="deactivate"
                                            class="{{ $component->link() }}"
                                            data-cy="deactivate"
                                        >
                                            @icon('remove-alt', $component->icon())
                                            <span>Deactivate</span>
                                        </button>
                                    @endcan

                                    @can('delete', $user)
                                        <div class="{{ $component->divider() }}"></div>
                                        <button
                                            x-on:click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($user) }});"
                                            class="{{ $component->link() }}"
                                            data-cy="delete"
                                        >
                                            @icon('delete', $component->icon())
                                            <span>Delete</span>
                                        </button>
                                    @endcan
                                </x-slot>
                            </x-dropdown>
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

    <x-tips section="users" />

    <x-modal color="red" headline="Delete account?" icon="warning" :url="route('users.delete')">
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

    <x-modal color="blue" headline="Deactivate user?" icon="duplicate" :url="route('users.confirm-deactivate')" event="modal-deactivate">
        <x-slot name="footer">
            <span class="flex w-full | sm:col-start-2">
                <button form="form-deactivate" class="button button-primary w-full">
                    Deactivate
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
