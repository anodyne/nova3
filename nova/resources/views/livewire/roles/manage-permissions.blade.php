<div>
    <x-content-box>
        <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 tracking-tight">Permissions Assigned to this Role</h3>

        <div class="flex justify-between mt-4">
            @if ($permissions->total() > 0)
                <div class="w-full sm:w-1/3">
                    <x-input.group>
                        <x-input.text wire:model.debounce.500ms="filters.search" placeholder="Find assigned permissions">
                            <x-slot:leadingAddOn>
                                @icon('search', 'h-5 w-5')
                            </x-slot:leadingAddOn>

                            <x-slot:trailingAddOn>
                                @if ($filters['search'])
                                    <x-button color="gray-text" size="none" wire:click="$set('filters.search', '')">
                                        @icon('close')
                                    </x-button>
                                @endif
                            </x-slot:trailingAddOn>
                        </x-input.text>
                    </x-input.group>
                </div>

                @can('update', $role)
                    <div class="flex items-center space-x-4">
                        @if (count($selected) > 0)
                            <x-button color="danger-outline" size="sm" wire:click="detachSelectedPermissions" leading="delete">
                                Remove {{ count($selected) }} @choice('permission|permissions', count($selected))
                            </x-button>
                        @endif

                        <x-button type="button" color="primary" size="sm" wire:click="$emit('openModal', 'roles:select-permissions-modal')" leading="add">
                            Add permissions
                        </x-button>
                    </div>
                @endcan
            @endif
        </div>
    </x-content-box>

    @if ($permissions->total() > 0)
        <x-table class="rounded-b-lg">
            <x-slot:head>
                @can('update', $role)
                    <x-table.heading class="pr-0 w-8 leading-0">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                @endcan

                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Description</x-table.heading>
            </x-slot:head>

            <x-slot:body>
                @if ($selectPage)
                    <x-table.row>
                        <x-table.cell class="bg-primary-50 dark:bg-primary-900" colspan="3">
                            @unless ($selectAll)
                                <div>
                                    <span class="text-primary-600 dark:text-primary-400">You've selected <strong>{{ $permissions->count() }}</strong> permissions assigned to this role. Do you want to select all <strong>{{ $permissions->total() }}</strong>?</span>

                                    <x-button size="none" color="primary-text" wire:click="selectAll" class="ml-1">Select All</x-button>
                                </div>
                            @else
                                <span class="text-primary-600 dark:text-primary-400">You've selected all <strong>{{ $permissions->total() }}</strong> permissions assigned to this role.</span>
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @foreach ($permissions as $permission)
                    <x-table.row wire:key="row-{{ $permission->id }}">
                        @can('update', $role)
                            <x-table.cell class="pr-0 leading-0">
                                <x-input.checkbox wire:model="selected" value="{{ $permission->id }}" />
                            </x-table.cell>
                        @endcan

                        <x-table.cell>{{ $permission->display_name }}</x-table.cell>
                        <x-table.cell>{{ $permission->description }}</x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot:body>
        </x-table>

        @if ($permissions->total() > $permissions->perPage())
            <x-content-box class="border-t border-gray-50" height="xs">
                {{ $permissions->withQueryString()->links() }}
            </x-content-box>
        @endif
    @else
        <x-content-box class="text-center">
            @icon('lock', 'mx-auto h-12 w-12 text-gray-500')

            <h3 class="mt-2 text-sm font-medium text-gray-900">No permissions</h3>

            @can('update', $role)
                <p class="mt-1 text-sm text-gray-600">
                    Get started by assigning permissions to this role.
                </p>

                <div class="mt-6">
                    <x-button color="primary" wire:click="$emit('openModal', 'roles:select-permissions-modal')">
                        Add permissions
                    </x-button>
                </div>
            @endcan
        </x-content-box>
    @endif
</div>
