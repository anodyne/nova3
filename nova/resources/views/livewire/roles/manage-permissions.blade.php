<div x-data>
    <x-content-box>
        <div class="flex justify-between">
            <div>
                <h3 class="font-bold text-xl text-gray-12 tracking-tight">Permissions Assigned to This Role</h3>
                <p class="mt-1 text-gray-10 space-y-6">You can add permissions to this role from here.</p>
            </div>

            <div>
                <x-button type="button" size="xs" wire:click="$emit('openModal', 'roles:add-permissions-modal')">
                    Add permissions
                </x-button>
            </div>
        </div>
    </x-content-box>

    <x-table class="rounded-b-lg">
        <x-slot name="head">
            <x-table.heading>Name</x-table.heading>
            <x-table.heading>Description</x-table.heading>
            <x-table.heading />
        </x-slot>
        <x-slot name="body">
            @foreach ($permissions as $permission)
                <x-table.row>
                    <x-table.cell>{{ $permission->display_name }}</x-table.cell>
                    <x-table.cell>{{ $permission->description }}</x-table.cell>
                    <x-table.cell>
                        <x-button color="gray-text" size="none" wire:click="removePermission({{ $permission->id }})">
                            @icon('delete', 'h-5 w-5')
                        </x-button>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
</div>
