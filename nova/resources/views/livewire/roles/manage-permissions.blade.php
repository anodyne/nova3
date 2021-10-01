<div x-data>
    <x-content-box>
        <div class="flex justify-between">
            <div>
                <h3 class="font-bold text-xl text-gray-12 tracking-tight">Permissions Assigned to This Role</h3>
                <p class="mt-1 text-gray-10 space-y-6">You can add permissions to this role from here.</p>
            </div>

            <div class="flex items-center space-x-2">
                <x-dropdown placement="bottom-end">
                    <x-slot name="trigger">
                        @icon('settings', 'h-5 w-5')
                    </x-slot>

                    <x-dropdown.group>
                        <x-dropdown.item type="button" icon="delete" wire:click="detachSelectedPermissions">
                            Delete
                        </x-dropdown.item>
                    </x-dropdown.group>
                </x-dropdown>

                <x-button type="button" size="xs" wire:click="$emit('openModal', 'roles:add-permissions-modal')">
                    Add permissions
                </x-button>
            </div>
        </div>
    </x-content-box>

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
                            <span class="text-blue-11">You've selected <strong>{{ $permissions->count() }}</strong> permissions assigned to this role. Do you want to select all <strong>{{ $permissions->total() }}</strong>?</span>

                            <x-button size="none" color="blue-text" wire:click="selectAll" class="ml-1">Select All</x-button>
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

    <div class="px-4 py-2 border-t border-gray-6 sm:px-6 sm:py-3">
        {{ $permissions->withQueryString()->links() }}
    </div>
</div>
