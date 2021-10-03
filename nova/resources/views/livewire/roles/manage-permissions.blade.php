<div>
    <x-content-box>
        <h3 class="font-bold text-xl text-gray-12 tracking-tight">Permissions Assigned to this Role</h3>

        <div class="flex justify-between mt-4">
            <div class="w-full sm:w-1/3">
                <x-input.group>
                    <x-input.text wire:model.debounce.500ms="search" placeholder="Find permissions...">
                        <x-slot name="leadingAddOn">
                            @icon('search', 'h-5 w-5')
                        </x-slot>

                        <x-slot name="trailingAddOn">
                            @if ($search)
                                <x-button color="gray-text" size="none" wire:click="$set('search', '')">
                                    @icon('close')
                                </x-button>
                            @endif
                        </x-slot>
                    </x-input.text>
                </x-input.group>
            </div>

            @if ($permissions->total() > 0)
                <div class="flex items-center space-x-4">
                    @if (count($selected) > 0)
                        <x-button color="red-soft" size="sm" wire:click="detachSelectedPermissions">
                            Remove {{ count($selected) }} @choice('permission|permissions', count($selected))
                        </x-button>
                    @endif

                    <x-button type="button" color="blue" size="sm" wire:click="$emit('openModal', 'roles:select-permissions-modal')">
                        Add permissions
                    </x-button>
                </div>
            @endif
        </div>
    </x-content-box>

    @if ($permissions->total() > 0)
        <x-table class="rounded-b-lg">
            <x-slot name="head">
                <x-table.heading class="pr-0 w-8 leading-0">
                    <x-input.checkbox wire:model="selectPage" />
                </x-table.heading>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Description</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row>
                        <x-table.cell class="bg-blue-3" colspan="3">
                            @unless ($selectAll)
                                <div>
                                    <span class="text-blue-11">You've selected <strong>{{ $permissions->count() }}</strong> permissions assigned to this role. Do you want to select all <strong>{{ $permissions->total() }}</strong>?</span>

                                    <x-button size="none" color="blue-text" wire:click="selectAll" class="ml-1">Select All</x-button>
                                </div>
                            @else
                                <span class="text-blue-11">You've selected all <strong>{{ $permissions->total() }}</strong> permissions assigned to this role.</span>
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @foreach ($permissions as $permission)
                    <x-table.row wire:key="row-{{ $permission->id }}">
                        <x-table.cell class="pr-0 leading-0">
                            <x-input.checkbox wire:model="selected" value="{{ $permission->id }}" />
                        </x-table.cell>
                        <x-table.cell>{{ $permission->display_name }}</x-table.cell>
                        <x-table.cell>{{ $permission->description }}</x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot>
        </x-table>

        @if ($permissions->total() > $permissions->perPage())
            <x-content-box class="border-t border-gray-3" height="xs">
                {{ $permissions->withQueryString()->links() }}
            </x-content-box>
        @endif
    @else
        <x-content-box class="text-center">
            @icon('lock', 'mx-auto h-12 w-12 text-gray-9')

            <h3 class="mt-2 text-sm font-medium text-gray-12">No permissions</h3>

            <p class="mt-1 text-sm text-gray-11">
                Get started by assigning permissions to this role.
            </p>

            <div class="mt-6">
                <x-button color="blue" wire:click="$emit('openModal', 'roles:select-permissions-modal')">
                    Add permissions
                </x-button>
            </div>
        </x-content-box>
    @endif
</div>
