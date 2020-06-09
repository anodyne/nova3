@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$role->display_name">
        <x-slot name="pretitle">
            <a href="{{ route('roles.index') }}">Roles</a>
        </x-slot>
    </x-page-header>

    <x-under-construction feature="Roles">
        <li>Permissions cannot be updated for a role</li>
        <li>Users cannot be assigned / removed from a role</li>
    </x-under-construction>

    <x-panel x-data="{ tab: 'users' }">
        @if ($role->default)
            <div class="bg-info-100 border-t border-b border-info-200 p-4 | sm:rounded-t-md sm:border-t-0">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @icon('check-alt', 'h-6 w-6 text-info-600')
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium text-info-900">
                            Default role for new users
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-info-800">
                            <p>New users are automatically assigned this role when they're activated. Be careful when making any updates to ensure new users have the correct permissions.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div>
            <div class="p-4 | sm:hidden">
                <select x-on:change="tab = $event.target.value" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 transition ease-in-out duration-150">
                    <option value="info" x-bind:selected="tab === 'info'">Info</option>
                    <option value="permissions" x-bind:selected="tab === 'permissions'">Permissions</option>
                    <option value="users" x-bind:selected="tab === 'users'">Users</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 px-4 | sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            x-on:click.prevent="tab = 'info'"
                            href="#info"
                            class="inline-flex items-center whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'info', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'info' }"
                        >
                            Info
                        </a>
                        <a
                            x-on:click.prevent="tab = 'permissions'"
                            href="#permissions"
                            class="inline-flex items-center whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'permissions', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'permissions' }"
                        >
                            Permissions
                            <x-badge size="sm" class="ml-2">
                                {{ $role->permissions->count() }}
                            </x-badge>
                        </a>
                        <a
                            x-on:click.prevent="tab = 'users'"
                            href="#users"
                            class="inline-flex items-center whitespace-no-wrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm leading-5 focus:outline-none"
                            x-bind:class="{ 'border-blue-500 text-blue-600': tab === 'users', 'text-gray-500 hover:text-gray-700 hover:border-gray-300': tab != 'users' }"
                        >
                            Users
                            <x-badge size="sm" class="ml-2">
                                {{ $role->users->count() }}
                            </x-badge>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <form action="{{ route('roles.update', $role) }}" method="POST" role="form" data-cy="form">
            @csrf
            @method('put')

            <div x-show="tab === 'info'">
                <x-form.section title="Role Info" message="A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.">
                    <x-input.group label="Name" for="display_name" :error="$errors->first('display_name')">
                        <x-input.text
                            id="display_name"
                            name="display_name"
                            :value="old('display_name', $role->display_name)"
                            data-cy="display_name"
                        />
                    </x-input.group>

                    <x-input.group label="Key" for="name" :error="$errors->first('name')">
                        <x-input.text id="name" name="name" :value="old('name', $role->name)" data-cy="name" />
                    </x-input.group>

                    <x-input.group label="Description" for="description">
                        <x-input.textarea id="description" name="description" rows="3" data-cy="description">{{ old('description', $role->description) }}</x-input.textarea>
                    </x-input.group>

                    <x-input.group>
                        <x-input.toggle field="default" :value="old('default', $role->default ?? '')">
                            Assign this role to new users
                        </x-input.toggle>
                    </x-input.group>
                </x-form.section>
            </div>

            <div x-show="tab === 'permissions'">
                <x-form.section title="Permissions" message="Permissions are the actions a signed in user can take throughout Nova. Feel free to add whatever permissions you want to this role.">
                    <x-input.group label="Assign permissions">
                        @foreach ($role->permissions as $permission)
                            <span class="tag mb-3">
                                <span>{{ $permission->display_name }}</span>
                                <button type="button" class="flex-shrink-0 -mr-0.5 ml-1.5 inline-flex text-gray-500 focus:outline-none focus:text-gray-600" aria-label="Remove small badge">
                                    <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                        <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                    </svg>
                                </button>
                            </span>
                        @endforeach

                        <button class="tag tag-primary mb-3">
                            Add permission
                            @icon('add', 'h-4 w-4 text-blue-700 ml-1')
                        </button>
                    </x-input.group>
                </x-form.section>
            </div>

            <div x-show="tab === 'users'" class="px-4 pt-4 | sm:px-6 sm:pt-6">
                <p class="mb-6">These are the active users who have been assigned this role. You can add and remove users from this role from here.</p>

                <div class="mb-8 sm:w-1/2 md:1/3">
                    <div class="flex flex-col relative w-full rounded-md border border-gray-200 bg-white shadow-md transition ease-in-out duration-200 overflow-hidden">
                        <div class="p-2">
                            <x-input.group for="search">
                                <x-input.text id="search" placeholder="Find a user...">
                                    <x-slot name="leadingAddOn">
                                        @icon('search', 'h-5 w-5 text-gray-400')
                                    </x-slot>
                                </x-input.text>
                            </x-input.group>
                        </div>

                        <div class="block w-full border-t border-gray-200">
                            <div class="hidden py-6 text-center">
                                <div class="text-gray-500 text-lg leading-9">No users found matching</div>
                                <div class="text-gray-900 text-lg font-medium">&lsquo;AgentPhoenix&rsquo;</div>
                                <button class="mt-4 button button-primary">Create this tag</button>
                            </div>
                            <div class="flex flex-col py-1">
                                <div class="px-3 pt-2 pb-1 uppercase tracking-wide font-medium text-xs text-gray-500">Found Users</div>
                                <a href="#" class="px-3 py-2 hover:bg-gray-100">AgentPhoenix</a>
                                <a href="#" class="px-3 py-2 hover:bg-gray-100">DeathKitten</a>
                                <a href="#" class="px-3 py-2 hover:bg-gray-100">Emily</a>
                                <a href="#" class="px-3 py-2 hover:bg-gray-100">greenfelt</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 max-w-lg mx-auto | lg:grid-cols-3 lg:max-w-none">
                    @foreach ($role->users as $user)
                        <div class="group flex items-center justify-between bg-gray-50 border border-gray-200 rounded-md py-2 px-4 transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <x-avatar :url="$user->avatar_url" size="sm" class="mr-3" />
                                {{ $user->name }}
                            </div>
                            <button class="sm:invisible group-hover:visible bg-transparent text-gray-500 transition ease-in-out duration-150 hover:text-red-500">
                                @icon('close', 'h-5 w-5')
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update Role</button>

                <a href="{{ route('roles.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </form>
    </x-panel>
@endsection
