@extends($meta->template)

@section('content')
    <x-page-header :title="$role->display_name">
        <x-slot name="pretitle">
            <a href="{{ route('roles.index') }}">Roles</a>
        </x-slot>
    </x-page-header>

    <x-panel x-data="tabsList('details')">
        <div>
            <x-content-box class="sm:hidden">
                <select @change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-150 sm:text-sm rounded-md">
                    <option value="details">Details</option>
                    <option value="permissions">Permissions</option>
                    <option value="users">Users</option>
                </select>
            </x-content-box>
            <div class="hidden sm:block">
                <div class="border-b border-gray-6 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('details'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('details') }" @click.prevent="switchTab('details')">
                            Details
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('permissions'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('permissions') }" @click.prevent="switchTab('permissions')">
                            Permissions
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('users'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('users') }" @click.prevent="switchTab('users')">
                            Users
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <x-form :action="route('roles.update', $role)" method="PUT" :divide="false" :space="false" x-show="isTab('details')">
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

            <x-form.footer class="mt-4 md:mt-8">
                <x-button type="submit" color="blue">Update Role</x-button>
                <x-link :href="route('roles.index')" color="white">Cancel</x-link>
            </x-form.footer>

            <input type="hidden" name="id" value="{{ $role->id }}">
        </x-form>

            {{-- <div x-show="isTab('permissions')" class="px-6">
                <ul class="space-y-2">
                    @foreach ($role->permissions as $permission)
                        <li class="py-2 px-2 odd:bg-gray-3 rounded-md">
                            <div class="flex flex-col">
                                <div class="text-gray-12 font-medium">{{ $permission->display_name }}</div>
                                <div class="text-sm text-gray-11">{{ $permission->description }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <x-button color="blue-soft" size="xs" class="mt-4">
                    @icon('add-alt', 'h-5 w-5')
                    <span class="ml-2">Add permission</span>
                </x-button>
            </div> --}}

            {{-- <x-form.section x-show="isTab('permissions')" title="Permissions">
                <x-slot name="message">
                    <p>Permissions are the actions an authenticated user can perform throughout Nova. Feel free to add whatever permissions you want to this role.</p>

                    <x-button color="blue-soft" size="xs">
                        @icon('add-alt', 'h-5 w-5')
                        <span class="ml-2">Add permission</span>
                    </x-button>
                </x-slot>

                <ul>
                    @foreach ($role->permissions as $permission)
                        <li class="group py-3 md:px-4 md:rounded-md hover:bg-gray-2">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <div class="text-gray-12 font-medium">{{ $permission->display_name }}</div>
                                    <div class="text-sm text-gray-11">{{ $permission->description }}</div>
                                </div>

                                <div class="md:hidden group-hover:block">
                                    <x-button color="gray-text" size="none">
                                        @icon('delete')
                                    </x-button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </x-form.section> --}}

            {{-- <x-form.section x-show="isTab('users')" title="Users" message="You can quickly add users to this role from here.">
                <x-input.group label="Assign users">
                    @livewire('users:manage-users', ['users' => $role->users])
                </x-input.group>
            </x-form.section> --}}

        <div x-show="isTab('permissions')" x-cloak>
            @if ($role->default)
                <div class="mt-6 mx-6 bg-purple-3 border border-purple-6 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @icon('check-alt', 'h-6 w-6 text-purple-9')
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium text-purple-11">
                                Default role for new users
                            </h3>
                            <div class="mt-2 text-sm text-purple-11">
                                <p>New users are automatically assigned this role when they're activated. Be careful when making any updates to ensure new users have the correct permissions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @livewire('roles:manage-permissions')
        </div>

        <div x-show="isTab('users')" x-cloak>
            @livewire('roles:manage-permissions')
        </div>
    </x-panel>

    {{-- <x-panel>
        @if ($role->default)
            <div class="bg-purple-3 border-t border-b border-purple-6 p-4 | sm:rounded-t-md sm:border-t-0">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @icon('check-alt', 'h-6 w-6 text-purple-9')
                    </div>
                    <div class="ml-3">
                        <h3 class="font-medium text-purple-11">
                            Default role for new users
                        </h3>
                        <div class="mt-2 text-sm text-purple-11">
                            <p>New users are automatically assigned this role when they're activated. Be careful when making any updates to ensure new users have the correct permissions.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <x-form :action="route('roles.update', $role)" method="PUT">
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

            <x-form.section title="Permissions" message="Permissions are the actions a signed in user can take throughout Nova. Feel free to add whatever permissions you want to this role.">
                <x-input.group label="Assign permissions">
                    @livewire('roles:manage-permissions', ['permissions' => $role->permissions])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Users" message="You can quickly add users to this role from here.">
                <x-input.group label="Assign users">
                    @livewire('users:manage-users', ['users' => $role->users])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Update Role</x-button>
                <x-link :href="route('roles.index')" color="white">Cancel</x-link>
            </x-form.footer>

            <input type="hidden" name="id" value="{{ $role->id }}">
        </x-form>
    </x-panel> --}}
@endsection
