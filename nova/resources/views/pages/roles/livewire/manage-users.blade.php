<div x-on:click.away="$wire.set('search', '')">
    <x-panel>
        <x-content-box height="xs" width="xs" class="rounded-t-lg bg-gray-50 dark:bg-gray-950/30">
            <div class="flex justify-between space-x-4">
                <div class="relative w-full">
                    <x-input.group>
                        <x-input.text
                            wire:model.debounce.500ms="search"
                            placeholder="Find a user to assign (type * to see all users)"
                        >
                            <x-slot name="leading">
                                <x-icon name="search" size="sm"></x-icon>
                            </x-slot>

                            <x-slot name="trailing">
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
                            class="absolute z-10 mt-2 max-h-60 w-full divide-y divide-gray-200 overflow-y-scroll rounded-md bg-white shadow-lg ring-1 ring-gray-950/5 dark:divide-gray-600/50 dark:bg-gray-800"
                        >
                            @if ($filteredUsers->count() === 0)
                                <x-empty-state.small icon="users" title="No user(s) found"></x-empty-state.small>
                            @else
                                <x-dropdown.group>
                                    @foreach ($filteredUsers as $user)
                                        <x-dropdown.item
                                            type="button"
                                            class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none dark:text-gray-300 dark:hover:bg-gray-600/50 md:text-sm"
                                            wire:click="assignUser({{ $user->id }})"
                                        >
                                            {{ $user->name }}
                                        </x-dropdown.item>
                                    @endforeach
                                </x-dropdown.group>

                                @can('viewAny', Nova\Users\Models\User::class)
                                    <x-dropdown.group>
                                        <x-dropdown.text>Don't see the user you're looking for?</x-dropdown.text>
                                        <x-dropdown.item :href="route('users.index')">
                                            Go to user management &rarr;
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                @endcan
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </x-content-box>

        @if ($users->count() > 0)
            <div
                class="divide-y divide-gray-200 rounded-b-lg border-t border-gray-200 dark:divide-gray-800 dark:border-gray-800"
            >
                @foreach ($users as $user)
                    <div
                        class="flex items-center justify-between bg-white px-6 py-3 last:rounded-b-lg dark:bg-gray-900"
                        wire:key="row-{{ $user->id }}"
                    >
                        <div class="flex items-center gap-2 truncate font-medium text-gray-900 dark:text-gray-100">
                            <x-status :status="$user->status"></x-status>
                            <span>{{ $user->name }}</span>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <x-dropdown placement="bottom-end">
                                <x-slot name="trigger" color="neutral-danger">
                                    <x-icon name="trash" size="sm"></x-icon>
                                </x-slot>

                                <x-dropdown.group>
                                    <x-dropdown.text>
                                        Are you sure you want to remove the
                                        <strong class="font-semibold text-gray-700 dark:text-gray-200">
                                            {{ $role->display_name ?? '' }}
                                        </strong>
                                        role from {{ $user->name }}?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger
                                        type="button"
                                        icon="trash"
                                        wire:click="unassignUser({{ $user->id }})"
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
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-content-box class="border-t border-gray-200 text-center dark:border-gray-800">
                <x-icon name="users" size="h-12 w-12" class="mx-auto text-gray-500"></x-icon>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No user(s) assigned</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Get started by assigning a user this role</p>
            </x-content-box>
        @endif
    </x-panel>

    <input type="hidden" name="assigned_users" value="{{ $assignedUsers }}" />
</div>