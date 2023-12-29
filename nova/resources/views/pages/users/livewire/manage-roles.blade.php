<div>
    <x-panel.manage>
        <x-panel.manage.search :search="$search" placeholder="Find a role to assign (type * to see all roles)">
            @if ($searchResults->count() === 0)
                <x-empty-state.small icon="users" title="No role(s) found"></x-empty-state.small>
            @else
                <x-dropdown.group>
                    @foreach ($searchResults as $role)
                        <x-panel.manage.result-item
                            :value="$role->id"
                            :text="$role->display_name"
                        ></x-panel.manage.result-item>
                    @endforeach
                </x-dropdown.group>
            @endif
        </x-panel.manage.search>

        @if ($roles->count() > 0)
            <div
                class="divide-y divide-gray-950/5 rounded-b-lg border-t border-gray-950/5 dark:divide-white/5 dark:border-white/5"
            >
                @foreach ($roles as $role)
                    <div
                        class="flex items-center justify-between bg-white px-6 py-3 last:rounded-b-lg dark:bg-gray-900"
                        wire:key="row-{{ $role->id }}"
                    >
                        <div class="truncate font-medium text-gray-900 dark:text-gray-100">
                            {{ $role->display_name }}
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
                                        role from {{ $user->name ?? '' }}?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger
                                        type="button"
                                        icon="trash"
                                        wire:click="remove({{ $role->id }})"
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
            <x-panel.manage.empty
                icon="shield"
                heading="No role(s) assigned"
                description="Get started by assigning a role to this user"
            ></x-panel.manage.empty>
        @endif
    </x-panel.manage>

    <input type="hidden" name="assigned_roles" value="{{ $assignedRoles }}" />
</div>
