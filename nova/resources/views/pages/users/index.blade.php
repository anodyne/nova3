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
        <dropdown placement="bottom-end" class="flex items-center text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150 mx-4 {{ request()->has('status') ? 'text-blue-500' : '' }}">
            @icon('filter', 'h-6 w-6')

            <template #dropdown>
                <div class="dropdown-text uppercase tracking-wide font-semibold text-gray-500">
                    Filter users
                </div>
                <a href="{{ route('users.index') }}" class="dropdown-link">All users</a>
                <a href="{{ route('users.index') }}?status=active" class="dropdown-link justify-between">
                    <span>Active users</span>
                    @if (request()->status === 'active')
                        @icon('check-alt', 'h-5 w-5 text-blue-500 flex-shrink-0')
                    @endif
                </a>
                <a href="{{ route('users.index') }}?status=pending" class="dropdown-link justify-between">
                    <span>Pending users</span>
                    @if (request()->status === 'pending')
                        @icon('check-alt', 'h-5 w-5 text-blue-500 flex-shrink-0')
                    @endif
                </a>
                <a href="{{ route('users.index') }}?status=inactive" class="dropdown-link justify-between">
                    <span>Inactive users</span>
                    @if (request()->status === 'inactive')
                        @icon('check-alt', 'h-5 w-5 text-blue-500 flex-shrink-0')
                    @endif
                </a>
                <a href="{{ route('users.index') }}?status=archived" class="dropdown-link justify-between">
                    <span>Archived users</span>
                    @if (request()->status === 'archived')
                        @icon('check-alt', 'h-5 w-5 text-blue-500 flex-shrink-0')
                    @endif
                </a>
            </template>
        </dropdown>

        @can('create', 'Nova\Users\Models\User')
            <a href="{{ route('users.create') }}" class="button button-primary" data-cy="create">
                Add User
            </a>
        @endcan
    </x-slot>
</x-page-header>

<x-panel x-data="tabs()" x-on:popstate.window="switchTab($event.state.tab)">
    <div>
        <div class="p-4 | sm:hidden">
            <select x-on:change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150">
                <option value="general" x-bind:selected="tab === 'general'">General</option>
                <option value="email" x-bind:selected="tab === 'email'">Email</option>
                <option value="defaults" x-bind:selected="tab === 'defaults'">Defaults</option>
                <option value="meta-tags" x-bind:selected="tab === 'meta-tags'">Meta Tags</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200 px-4 | sm:px-6">
                <nav class="-mb-px flex">
                    <a
                        x-on:click.prevent="switchTab('active')"
                        href="{{ route('users.index', 'active') }}"
                        class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                        x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'active', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'active' }"
                    >
                        Active
                    </a>
                    <a
                        x-on:click.prevent="switchTab('pending')"
                        href="{{ route('users.index', 'pending') }}"
                        class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                        x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'pending', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'pending' }"
                    >
                        Pending
                    </a>
                    <a
                        x-on:click.prevent="switchTab('inactive')"
                        href="{{ route('users.index', 'inactive') }}"
                        class="whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                        x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'inactive', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'inactive' }"
                    >
                        Inactive
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
                                <div class="mt-1">
                                    <x-badge size="sm" :type="$user->state->statusClass()">
                                        {{ $user->state }}
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

@push('scripts')
    <script>
        function tabs()
        {
            return {
                tab: '{{ $tab }}',

                switchTab (tab) {
                    this.tab = tab;
                    history.pushState({ tab: this.tab }, null, tab);
                }
            };
        }
    </script>
@endpush
