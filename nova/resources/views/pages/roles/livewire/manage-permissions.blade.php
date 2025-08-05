<x-panel>
    <x-spacing size="2xs">
        <x-panel.manage.search :$search placeholder="Find a permission to assign (type * to see all permissions)">
            @if ($searchResults->count() === 0)
                <x-empty-state.small :icon="Icon::Key" title="No permission(s) found"></x-empty-state.small>
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
    </x-spacing>

    @if ($permissions->count() > 0)
        <div class="divide-y divide-gray-950/5 dark:divide-white/5">
            @foreach ($permissions as $permission)
                <x-spacing class="flex items-center justify-between" size="row" wire:key="row-{{ $permission->id }}">
                    <div class="truncate font-medium text-gray-950 dark:text-white">
                        {{ $permission->display_name }}
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <x-dropdown placement="bottom end">
                            <x-slot name="trigger">
                                <x-button type="button" color="neutral-danger" size="none" text>
                                    <x-icon :name="Icon::Trash" size="sm"></x-icon>
                                </x-button>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to remove the
                                    <strong class="font-semibold">
                                        {{ $permission->display_name ?? '' }}
                                    </strong>
                                    permission from the {{ $role->display_name ?? '' }} role?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Icon::Trash"
                                    wire:click="remove({{ $permission->id }})"
                                    variant="danger"
                                >
                                    Remove
                                </x-dropdown.item>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Icon::Ban"
                                    x-on:click.prevent="$dispatch('dropdown-close')"
                                >
                                    Cancel
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>
                    </div>
                </x-spacing>
            @endforeach
        </div>
    @else
        <x-panel.manage.empty
            :icon="Icon::Key"
            heading="No permission(s) assigned"
            description="Get started by assigning a permission to this role"
        ></x-panel.manage.empty>
    @endif

    <input type="hidden" name="assigned_permissions" value="{{ $assignedPermissions }}" />
</x-panel>
