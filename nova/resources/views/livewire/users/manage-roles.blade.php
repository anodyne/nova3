<div>
    @can('update', $user)
        <x-content-box height="xs" width="xs" class="rounded-t-lg bg-gray-50 dark:bg-gray-950/30">
            <div class="flex justify-between space-x-4">
                <div class="relative w-full">
                    <x-input.group>
                        <x-input.text
                            wire:model.debounce.500ms="search"
                            placeholder="Find role to assign (type * to see all roles)"
                        >
                            <x-slot name="leadingAddOn">
                                <x-icon name="search" size="sm"></x-icon>
                            </x-slot>

                            <x-slot name="trailingAddOn">
                                @if ($search)
                                    <x-button.text tag="button" color="gray" wire:click="$set('search', '')">
                                        <x-icon name="dismiss" size="sm"></x-icon>
                                    </x-button.text>
                                @endif
                            </x-slot>
                        </x-input.text>
                    </x-input.group>

                    @if (filled($search))
                        <div
                            class="absolute z-10 mt-2 w-full rounded-md bg-white p-1.5 shadow-lg ring-1 ring-gray-950/5 dark:bg-gray-800"
                        >
                            @forelse ($filteredRoles as $role)
                                <x-dropdown.item
                                    type="button"
                                    class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none dark:text-gray-300 dark:hover:bg-gray-600/50 md:text-sm"
                                    wire:click="assignRole({{ $role->id }})"
                                >
                                    {{ $role->display_name }}
                                </x-dropdown.item>
                            @empty
                                <x-empty-state.small icon="lock-closed" title="No roles found"></x-empty-state.small>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </x-content-box>
    @endcan

    @if ($roles->count() > 0)
        <div
            @class([
                'divide-y divide-gray-200 rounded-b-lg dark:divide-gray-800',
                'rounded-t-lg' => ! gate()->allows('update', $user),
                'border-t border-gray-200 dark:border-gray-800' => gate()->allows('update', $user),
            ])
        >
            @foreach ($roles as $role)
                <div
                    class="flex items-center justify-between bg-white px-6 py-3 last:rounded-b-lg dark:bg-gray-900"
                    wire:key="row-{{ $role->id }}"
                >
                    <div class="truncate font-medium text-gray-900 dark:text-gray-100">{{ $role->display_name }}</div>

                    <div class="flex items-center justify-end space-x-3">
                        @can('update', $user)
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger" color="gray-danger">
                                    <x-icon name="trash" size="sm"></x-icon>
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to unassign the
                                        <strong class="font-semibold text-gray-700 dark:text-gray-200">
                                            {{ $role->display_name }}
                                        </strong>
                                        role from {{ $user->name }}?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger
                                        type="button"
                                        icon="trash"
                                        wire:click="unassignRole({{ $role->id }})"
                                    >
                                        Remove
                                    </x-dropdown.item-danger>
                                    <x-dropdown.item
                                        type="button"
                                        icon="prohibited"
                                        x-on:click.prevent="$dispatch('dropdown-close')"
                                    >
                                        Cancel
                                    </x-dropdown.item>
                                </x-dropdown.group>
                            </x-dropdown>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <x-content-box class="border-t border-gray-200 text-center dark:border-gray-800">
            <x-icon name="lock-closed" size="h-12 w-12" class="mx-auto text-gray-500"></x-icon>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No roles assigned</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Get started by assigning roles to this user</p>
        </x-content-box>
    @endif
</div>
