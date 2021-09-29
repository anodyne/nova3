<div>
    <x-content-box>
        <div class="flex justify-between">
            <div>
                <h3 class="font-bold text-xl text-gray-12 tracking-tight">Permissions Assigned to This Role</h3>
                <p class="mt-1 text-gray-10 space-y-6">You can add permissions to this role from here.</p>
            </div>

            <div>
                <x-button size="xs">Add a permission</x-button>
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
            <x-table.row>
                <x-table.cell>AgentPhoenix</x-table.cell>
                <x-table.cell>Description</x-table.cell>
                <x-table.cell></x-table.cell>
            </x-table.row>
            <x-table.row>
                <x-table.cell>Death Kitten</x-table.cell>
                <x-table.cell>Description</x-table.cell>
                <x-table.cell></x-table.cell>
            </x-table.row>
            <x-table.row>
                <x-table.cell>greenfelt</x-table.cell>
                <x-table.cell>Description</x-table.cell>
                <x-table.cell></x-table.cell>
            </x-table.row>
        </x-slot>
    </x-table>
</div>
