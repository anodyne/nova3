<div>
    <x-panel.manage>
        <x-panel.manage.search
            :search="$search"
            placeholder="Find a permission to assign (type * to see all permissions)"
        >
            @if ($searchResults->count() === 0)
                <x-empty-state.small icon="key" title="No permission(s) found"></x-empty-state.small>
            @else
                <x-dropdown.group>
                    @foreach ($searchResults as $permission)
                        <x-panel.manage.result-item
                            :value="$permission->id"
                            :text="$permission->display_name"
                        ></x-panel.manage.result-item>
                    @endforeach
                </x-dropdown.group>
            @endif
        </x-panel.manage.search>

        @if ($permissions->count() > 0)
            <div
                class="divide-y divide-gray-950/5 rounded-b-lg border-t border-gray-950/5 dark:divide-white/5 dark:border-white/5"
            >
                @foreach ($permissions as $permission)
                    <div
                        class="flex items-center justify-between bg-white px-6 py-3 last:rounded-b-lg dark:bg-gray-900"
                        wire:key="row-{{ $permission->id }}"
                    >
                        <div class="truncate font-medium text-gray-900 dark:text-gray-100">
                            {{ $permission->display_name }}
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
                                            {{ $permission->display_name ?? '' }}
                                        </strong>
                                        permission from the {{ $role->display_name ?? '' }} role?
                                    </x-dropdown.text>
                                </x-dropdown.group>
                                <x-dropdown.group>
                                    <x-dropdown.item-danger
                                        type="button"
                                        icon="trash"
                                        wire:click="remove({{ $permission->id }})"
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
                icon="key"
                heading="No permission(s) assigned"
                description="Get started by assigning a permission to this role"
            ></x-panel.manage.empty>
        @endif
    </x-panel.manage>

    <input type="hidden" name="assigned_permissions" value="{{ $assignedPermissions }}" />
</div>
