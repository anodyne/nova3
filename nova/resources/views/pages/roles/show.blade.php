@extends($meta->template)

@section('content')
    <x-panel x-data="tabsList('details')">
        <x-panel.header :title="$role->display_name">
            <x-slot:actions>
                @can('viewAny', $role::class)
                    <x-button.text :href="route('roles.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan

                @can('update', $role)
                    <x-button.filled :href="route('roles.edit', $role)" leading="edit" color="primary">Edit</x-button.filled>
                @endcan
            </x-slot:actions>

            <div>
                <x-content-box class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="details">Details</option>
                        <option value="permissions">Permissions</option>
                        <option value="users">Users</option>
                    </x-input.select>
                </x-content-box>
                <div class="hidden sm:block">
                    <x-content-box height="none">
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
        </x-panel.header>

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
                        <x-icon name="check" size="md" class="shrink-0 text-success-500"></x-icon>
                        <span>Assigned to new users</span>
                    </div>
                @else
                    <div class="flex items-center space-x-2 text-danger-600 font-medium">
                        <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500"></x-icon>
                        <span>Not assigned to new users</span>
                    </div>
                @endif
            </x-form.section>
        </x-form>

        <div x-show="isTab('permissions')" x-cloak>
            @livewire('roles:manage-permissions', ['role' => $role])
        </div>

        <div x-show="isTab('users')" x-cloak>
            @livewire('roles:manage-users', ['role' => $role])
        </div>
    </x-panel>
@endsection
