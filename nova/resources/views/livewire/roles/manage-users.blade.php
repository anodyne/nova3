<div>
    <x-content-box>
        <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 tracking-tight">Users Assigned this Role</h3>

        <div class="flex justify-between mt-4">
            @if ($users->total() > 0)
                <div class="w-full sm:w-1/3">
                    <x-input.group>
                        <x-input.text wire:model.debounce.500ms="filters.search" placeholder="Find assigned users">
                            <x-slot:leadingAddOn>
                                <x-icon name="search" size="sm"></x-icon>
                            </x-slot:leadingAddOn>

                            <x-slot:trailingAddOn>
                                @if ($filters['search'])
                                    <x-button.text color="gray" wire:click="$set('filters.search', '')">
                                        <x-icon name="dismiss" size="sm"></x-icon>
                                    </x-button.text>
                                @endif
                            </x-slot:trailingAddOn>
                        </x-input.text>
                    </x-input.group>
                </div>

                <div class="flex items-center space-x-4">
                    <x-dropdown placement="bottom-end">
                        <x-slot:trigger>
                            <x-icon name="filter" size="md"></x-icon>
                        </x-slot:trigger>

                        <x-dropdown.group>
                            <x-dropdown.item type="button" wire:click="$set('filters.status', '')">
                                <div class="flex items-center justify-between w-full">
                                    <span>All users</span>
                                    @if ($filters['status'] === '')
                                        <x-icon name="check" size="md" class="text-success-500"></x-icon>
                                    @endif
                                </div>
                            </x-dropdown.item>
                            <x-dropdown.item type="button" wire:click="$set('filters.status', 'Nova\\\Users\\\Models\\\States\\\Active')">
                                <div class="flex items-center justify-between w-full">
                                    <span>Only active users</span>
                                    @if ($filters['status'] === 'Nova\Users\Models\States\Active')
                                        <x-icon name="check" size="md" class="text-success-500"></x-icon>
                                    @endif
                                </div>
                            </x-dropdown.item>
                            <x-dropdown.item type="button" wire:click="$set('filters.status', 'Nova\\\Users\\\Models\\\States\\\Inactive')">
                                <div class="flex items-center justify-between w-full">
                                    <span>Only inactive users</span>
                                    @if ($filters['status'] === 'Nova\Users\Models\States\Inactive')
                                        <x-icon name="check" size="md" class="text-success-500"></x-icon>
                                    @endif
                                </div>
                            </x-dropdown.item>
                        </x-dropdown.group>
                    </x-dropdown>

                    @can('update', $role)
                        @if (count($selected) > 0)
                            <x-button.outline color="danger" wire:click="unassignSelectedUsers" leading="trash">
                                Remove {{ count($selected) }} @choice('user|users', count($selected))
                            </x-button.outline>
                        @endif

                        <x-button.filled type="button" color="primary" wire:click="$emit('openModal', 'users:select-users-modal')" leading="add">
                            Add users
                        </x-button.filled>
                    @endcan
                </div>
            @endif
        </div>
    </x-content-box>

    @if ($users->total() > 0)
        <x-table class="rounded-b-lg">
            <x-slot:head>
                @can('update', $role)
                    <x-table.heading class="pr-0 w-8 leading-0">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                @endcan

                <x-table.heading>Name</x-table.heading>
            </x-slot:head>

            <x-slot:body>
                @if ($selectPage)
                    <x-table.row>
                        <x-table.cell class="bg-primary-50 dark:bg-primary-900" colspan="3">
                            @unless ($selectAll)
                                <span class="text-primary-600 dark:text-primary-400">You've selected <strong>{{ $users->count() }}</strong> users assigned this role. Do you want to select all <strong>{{ $users->total() }}</strong>?</span>

                                <x-button.text color="primary" wire:click="selectAll" class="ml-1">Select All</x-button.text>
                            @else
                                <span class="text-primary-600 dark:text-primary-400">You've selected all <strong>{{ $users->total() }}</strong> users assigned this role.</span>
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @foreach ($users as $user)
                    <x-table.row wire:key="row-{{ $user->id }}">
                        @can('update', $role)
                            <x-table.cell class="pr-0 leading-0">
                                <x-input.checkbox wire:model="selected" value="{{ $user->id }}" />
                            </x-table.cell>
                        @endcan

                        <x-table.cell>
                            <x-avatar.user :user="$user" :primary="$user->name" :secondaryStatus="true"></x-avatar.user>
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot:body>
        </x-table>

        @if ($users->total() > $users->perPage())
            <x-content-box class="border-t border-gray-50" height="xs">
                {{ $users->withQueryString()->links() }}
            </x-content-box>
        @endif
    @else
        <x-content-box class="text-center">
            <x-icon name="users" size="h-12 w-12" class="mx-auto text-gray-500"></x-icon>

            <h3 class="mt-2 text-sm font-medium text-gray-900">No users</h3>

            @can('update', $role)
                <p class="mt-1 text-sm text-gray-600">
                    Get started by assigning users this role.
                </p>

                <div class="mt-6">
                    <x-button.filled color="primary" wire:click="$emit('openModal', 'users:select-users-modal')">
                        Add users
                    </x-button.filled>
                </div>
            @endcan
        </x-content-box>
    @endif
</div>
