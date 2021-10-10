<div>
    <x-content-box>
        <h3 class="font-bold text-xl text-gray-12 tracking-tight">Roles Assigned to this User</h3>

        <div class="flex justify-between mt-4">
            @if ($roles->total() > 0)
                <div class="w-full sm:w-1/3">
                    <x-input.group>
                        <x-input.text wire:model.debounce.500ms="filters.search" placeholder="Find assigned roles...">
                            <x-slot name="leadingAddOn">
                                @icon('search', 'h-5 w-5')
                            </x-slot>

                            <x-slot name="trailingAddOn">
                                @if ($filters['search'])
                                    <x-button color="gray-text" size="none" wire:click="$set('filters.search', '')">
                                        @icon('close')
                                    </x-button>
                                @endif
                            </x-slot>
                        </x-input.text>
                    </x-input.group>
                </div>

                @can('update', $user)
                    <div class="flex items-center space-x-4">
                        @if (count($selected) > 0)
                            <x-button color="red-outline" size="sm" wire:click="detachSelectedRoles">
                                Remove {{ count($selected) }} @choice('role|roles', count($selected))
                            </x-button>
                        @endif

                        <x-button type="button" color="blue" size="sm" wire:click="$emit('openModal', 'roles:select-roles-modal')">
                            Add roles
                        </x-button>
                    </div>
                @endcan
            @endif
        </div>
    </x-content-box>

    @if ($roles->total() > 0)
        <x-table class="rounded-b-lg">
            <x-slot name="head">
                @can('update', $user)
                    <x-table.heading class="pr-0 w-8 leading-0">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                @endcan

                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Description</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row>
                        <x-table.cell class="bg-blue-3" colspan="3">
                            @unless ($selectAll)
                                <div>
                                    <span class="text-blue-11">You've selected <strong>{{ $roles->count() }}</strong> roles assigned to this user. Do you want to select all <strong>{{ $roles->total() }}</strong>?</span>

                                    <x-button size="none" color="blue-text" wire:click="selectAll" class="ml-1">Select All</x-button>
                                </div>
                            @else
                                <span class="text-blue-11">You've selected all <strong>{{ $roles->total() }}</strong> roles assigned to this user.</span>
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @foreach ($roles as $role)
                    <x-table.row wire:key="row-{{ $role->id }}">
                        @can('update', $user)
                            <x-table.cell class="pr-0 leading-0">
                                <x-input.checkbox wire:model="selected" value="{{ $role->id }}" />
                            </x-table.cell>
                        @endcan

                        <x-table.cell>{{ $role->display_name }}</x-table.cell>
                        <x-table.cell>{{ $role->description }}</x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot>
        </x-table>

        @if ($roles->total() > $roles->perPage())
            <x-content-box class="border-t border-gray-3" height="xs">
                {{ $roles->withQueryString()->links() }}
            </x-content-box>
        @endif
    @else
        <x-content-box class="text-center">
            @icon('lock', 'mx-auto h-12 w-12 text-gray-9')

            <h3 class="mt-2 text-sm font-medium text-gray-12">No roles</h3>

            @can('update', $user)
                <p class="mt-1 text-sm text-gray-11">
                    Get started by assigning roles to this user.
                </p>

                <div class="mt-6">
                    <x-button color="blue" wire:click="$emit('openModal', 'roles:select-roles-modal')">
                        Add roles
                    </x-button>
                </div>
            @endcan
        </x-content-box>
    @endif
</div>
