@extends($meta->template)

@section('content')
    <x-page-header :title="$role->display_name">
        <x-slot:pretitle>
            <a href="{{ route('roles.index') }}">Roles</a>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $role)
                <x-link :href="route('roles.edit', $role)" color="primary">Edit Role</x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel x-data="tabsList('details')">
        <div>
            <x-content-box class="sm:hidden">
                <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                    <option value="details">Details</option>
                    <option value="permissions">Permissions</option>
                    <option value="users">Users</option>
                </x-input.select>
            </x-content-box>
            <x-content-box class="hidden sm:block">
                <x-content-box height="none" class="border-b border-gray-200 dark:border-gray-200/10">
                    <nav class="-mb-px flex">
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('details'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('details') }" @click.prevent="switchTab('details')">
                            Details
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('permissions'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('permissions') }" @click.prevent="switchTab('permissions')">
                            Permissions
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('users'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('users') }" @click.prevent="switchTab('users')">
                            Users
                        </a>
                    </nav>
                </x-content-box>
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
                    <div class="flex items-center space-x-2 text-success-600 font-medium">
                        @icon('check', 'h-6 w-6 shrink-0 text-success-500')
                        <span>Assigned to new users</span>
                    </div>
                @else
                    <div class="flex items-center space-x-2 text-error-600 font-medium">
                        @icon('close', 'h-6 w-6 shrink-0 text-error-500')
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
