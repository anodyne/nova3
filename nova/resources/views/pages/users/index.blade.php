@extends($meta->template)

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
                <x-link :href="route('users.create')" color="blue" data-cy="create">
                    Add User
                </x-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <div>
            <x-content-box class="sm:hidden">
                <select @change="window.location.replace($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring focus:border-blue-7 sm:text-sm transition ease-in-out duration-150">
                    <option value="{{ route('users.index', 'status=active') }}"{{ request()->status === 'active' ? 'selected' : '' }}>Active Users</option>
                    <option value="{{ route('users.index', 'status=pending') }}"{{ request()->status === 'pending' ? 'selected' : '' }}>Pending Users</option>
                    <option value="{{ route('users.index', 'status=inactive') }}"{{ request()->status === 'inactive' ? 'selected' : '' }}>Inactive Users</option>
                    <option value="{{ route('users.index') }}"{{ !request()->has('status') ? 'selected' : '' }}>All Users</option>
                </select>
            </x-content-box>
            <div class="hidden sm:block">
                <div class="border-b border-gray-6 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            href="{{ route('users.index', 'status=active') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none @if (request()->status === 'active') border-blue-6 text-blue-9 @else text-gray-9 hover:text-gray-11 hover:border-gray-6 @endif"
                        >
                            Active
                        </a>
                        <a
                            href="{{ route('users.index', 'status=pending') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none @if (request()->status === 'pending') border-blue-6 text-blue-9 @else text-gray-9 hover:text-gray-11 hover:border-gray-6 @endif"
                        >
                            Pending
                        </a>
                        <a
                            href="{{ route('users.index', 'status=inactive') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none @if (request()->status === 'inactive') border-blue-6 text-blue-9 @else text-gray-9 hover:text-gray-11 hover:border-gray-6 @endif"
                        >
                            Inactive
                        </a>
                        <a
                            href="{{ route('users.index') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none @if (!request()->has('status')) border-blue-6 text-blue-9 @else text-gray-9 hover:text-gray-11 hover:border-gray-6 @endif"
                        >
                            All Users
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <x-content-box height="xs">
            <x-search-filter placeholder="Find a user..." :search="$search" />
        </x-content-box>

        <ul>
            @forelse ($users as $user)
                <li class="border-t border-gray-6">
                    <div class="block hover:bg-gray-2 focus:outline-none focus:bg-gray-2 transition duration-150 ease-in-out">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 pr-4 md:grid md:grid-cols-2 md:gap-4">
                                <x-avatar-meta :src="$user->avatar_url">
                                    <x-slot name="primaryMeta">{{ $user->name }}</x-slot>

                                    <x-slot name="secondaryMeta">
                                        <x-badge size="xs" :color="$user->status->color()">
                                            {{ $user->status->displayName() }}
                                        </x-badge>
                                    </x-slot>
                                </x-avatar-meta>

                                <div class="hidden md:block">
                                    <div>
                                        <div class="flex items-center text-sm text-gray-11">
                                            @icon('clock', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                            Last activity&nbsp;
                                            <time datetime="{{ $user->updated_at }}">
                                                {{ $user->updated_at->diffForHumans() }}
                                            </time>
                                        </div>
                                        @if ($user->latestLogin !== null)
                                            <div class="mt-2 flex items-center text-sm text-gray-11">
                                                @icon('sign-in', 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                Last signed in&nbsp;
                                                <time datetime="{{ $user->latestLogin->created_at }}">
                                                    {{ $user->latestLogin->created_at->diffForHumans() }}
                                                </time>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-dropdown placement="bottom-end">
                                    <x-slot name="trigger">@icon('more', 'h-6 w-6')</x-slot>

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
                                            <x-dropdown.item type="button" icon="remove-alt" @click="$dispatch('dropdown-toggle');$dispatch('modal-deactivate', {{ json_encode($user) }});" form="deactivate" data-cy="deactivate">
                                                <span>Deactivate</span>
                                            </x-dropdown.item>
                                        </x-dropdown.group>
                                    @endcan

                                    @can('delete', $user)
                                        <x-dropdown.group>
                                            <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($user) }});" data-cy="delete">
                                                <span>Delete</span>
                                            </x-dropdown.item-danger>
                                        </x-dropdown.group>
                                    @endcan
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

        <div class="px-4 py-2 border-t border-gray-6 sm:px-6 sm:py-3">
            {{ $users->withQueryString()->links() }}
        </div>
    </x-panel>

    <x-tips section="users" />

    <x-modal color="red" title="Delete User?" icon="warning" :url="route('users.delete')">
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

    <x-modal color="blue" title="Deactivate User?" icon="duplicate" :url="route('users.confirm-deactivate')" event="modal-deactivate">
        <x-slot name="footer">
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form-deactivate" color="blue" full-width>
                    Deactivate
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
