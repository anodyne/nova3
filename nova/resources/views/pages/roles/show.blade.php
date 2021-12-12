@extends($meta->template)

@section('content')
    <x-page-header :title="$role->display_name">
        <x-slot name="pretitle">
            <a href="{{ route('roles.index') }}">Roles</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $role)
                <x-link :href="route('roles.edit', $role)" color="blue">Edit Role</x-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel x-data="tabsList('details')">
        <div>
            <x-content-box class="sm:hidden">
                <select @change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-200 sm:text-sm rounded-md">
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

        <x-form action="" :divide="false" :space="false" x-show="isTab('details')">
            <x-form.section title="Role Details" message="A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $role->display_name }}</p>
                </x-input.group>

                <x-input.group label="Key">
                    <p class="font-semibold">{{ $role->name }}</p>
                </x-input.group>

                @if ($role->default)
                    <div class="flex items-center space-x-2 text-green-11 font-medium">
                        @icon('check', 'h-6 w-6 shrink-0 text-green-9')
                        <span>Assigned to new users</span>
                    </div>
                @else
                    <div class="flex items-center space-x-2 text-red-11 font-medium">
                        @icon('close', 'h-6 w-6 shrink-0 text-red-9')
                        <span>Not assigned to new users</span>
                    </div>
                @endif
            </x-form.section>

            <x-form.footer class="mt-4 md:mt-8">
                <x-link :href="route('roles.index')" color="white">Back</x-link>
            </x-form.footer>
        </x-form>

        <div x-show="isTab('permissions')" x-cloak>
            @livewire('roles:manage-permissions', ['role' => $role])
        </div>

        <div x-show="isTab('users')" x-cloak>
            @livewire('roles:manage-users', ['role' => $role])
        </div>
    </x-panel>
@endsection
