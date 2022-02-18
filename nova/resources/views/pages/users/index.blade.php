@extends($meta->template)

@section('content')
    <x-page-header>
        <x-slot:title>
            @if (request()->has('status'))
                {{ ucfirst(request()->status) }}
            @endif
            Users
        </x-slot:title>

        <x-slot:controls>
            @can('create', 'Nova\Users\Models\User')
                <x-link :href="route('users.create')" color="blue" data-cy="create">
                    Add User
                </x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <div>
            <x-content-box class="sm:hidden">
                <select @change="window.location.replace($event.target.value)" aria-label="Selected tab" class="mt-1 form-select bg-gray-1 block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-200 sm:text-sm rounded-md">
                    <option value="{{ route('users.index', 'status=active') }}" @selected(request()->status === 'active')>Active Users</option>
                    <option value="{{ route('users.index', 'status=pending') }}" @selected(request()->status === 'pending')>Pending Users</option>
                    <option value="{{ route('users.index', 'status=inactive') }}" @selected(request()->status === 'inactive')>Inactive Users</option>
                    <option value="{{ route('users.index') }}" @selected(! request()->has('status'))>All Users</option>
                </select>
            </x-content-box>
            <div class="hidden sm:block">
                <div class="border-b border-gray-6 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            href="{{ route('users.index', 'status=active') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none {{ request()->status === 'active' ? 'border-blue-6 text-blue-9' : 'border-transparent text-gray-9 hover:text-gray-11 hover:border-gray-6' }}"
                        >
                            Active
                        </a>
                        <a
                            href="{{ route('users.index', 'status=pending') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none {{ request()->status === 'pending' ? 'border-blue-6 text-blue-9' : 'border-transparent text-gray-9 hover:text-gray-11 hover:border-gray-6' }}"
                        >
                            Pending
                        </a>
                        <a
                            href="{{ route('users.index', 'status=inactive') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none {{ request()->status === 'inactive' ? 'border-blue-6 text-blue-9' : 'border-transparent text-gray-9 hover:text-gray-11 hover:border-gray-6' }}"
                        >
                            Inactive
                        </a>
                        <a
                            href="{{ route('users.index') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none {{ !request()->has('status') ? 'border-blue-6 text-blue-9' : 'border-transparent text-gray-9 hover:text-gray-11 hover:border-gray-6' }}"
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
                    <div class="block hover:bg-gray-2 focus:outline-none focus:bg-gray-2 transition duration-200 ease-in-out">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 pr-4 md:grid md:grid-cols-2 md:gap-4">
                                <x-avatar-meta :src="$user->avatar_url">
                                    <x-slot:primaryMeta>{{ $user->name }}</x-slot:primaryMeta>

                                    <x-slot:secondaryMeta>
                                        <x-badge size="xs" :color="$user->status->color()">
                                            {{ $user->status->displayName() }}
                                        </x-badge>
                                    </x-slot:secondaryMeta>
                                </x-avatar-meta>

                                <div class="hidden md:block">
                                    <div>
                                        @if ($user->updated_at !== null)
                                            <div class="flex items-center text-sm text-gray-11">
                                                @icon('clock', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                Last activity&nbsp;
                                                <time datetime="{{ $user->updated_at }}">
                                                    {{ $user->updated_at?->diffForHumans() }}
                                                </time>
                                            </div>
                                        @endif
                                        @if ($user->latestLogin !== null)
                                            <div class="mt-2 flex items-center text-sm text-gray-11">
                                                @icon('sign-in', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                                Last signed in&nbsp;
                                                <time datetime="{{ $user->latestLogin->created_at }}">
                                                    {{ $user->latestLogin->created_at?->diffForHumans() }}
                                                </time>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-dropdown placement="bottom-end">
                                    <x-slot:trigger>
                                        <x-icon.more class="h-6 w-6" />
                                    </x-slot:trigger>

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

                                                <x-slot:buttonForm>
                                                    <x-form :action="route('users.activate', $user)" id="activate" />
                                                </x-slot:buttonForm>
                                            </x-dropdown.item>
                                        </x-dropdown.group>
                                    @endcan

                                    @can('deactivate', $user)
                                        <x-dropdown.group>
                                            <x-dropdown.item type="button" icon="remove" @click="$dispatch('dropdown-toggle');$dispatch('modal-deactivate', {{ json_encode($user) }});" form="deactivate" data-cy="deactivate">
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
        <x-slot:footer>
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
        </x-slot:footer>
    </x-modal>

    <x-modal color="red" title="Deactivate User?" icon="remove" :url="route('users.confirm-deactivate')" event="modal-deactivate">
        <x-slot:footer>
            <span class="flex w-full sm:col-start-2">
                <x-button type="submit" form="form-deactivate" color="red" full-width>
                    Deactivate
                </x-button>
            </span>
            <span class="mt-3 flex w-full sm:mt-0 sm:col-start-1">
                <x-button @click="$dispatch('modal-close')" type="button" color="white" full-width>
                    Cancel
                </x-button>
            </span>
        </x-slot:footer>
    </x-modal>
@endsection
