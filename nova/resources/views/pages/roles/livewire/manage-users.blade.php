@use('Nova\Users\Models\User')

<x-panel>
    <x-spacing size="3xs" class="relative">
        <x-select
            wire:model.live.debounce="selected"
            variant="combobox"
            placeholder="Find a user to assign..."
            clearable
        >
            @foreach ($models as $model)
                <x-select.option :value="$model->id">
                    <div class="flex items-center gap-2.5">
                        <x-status :status="$model->status" />
                        {{ $model->name }}
                    </div>
                </x-select.option>
            @endforeach
        </x-select>
    </x-spacing>

    <x-spacing.group divided>
        @forelse ($users as $user)
            <x-panel.group.row wire:key="user-row-{{ $user->id }}">
                <x-avatar.user :$user status />

                <div class="flex items-center leading-0">
                    <x-dropdown placement="bottom end">
                        <x-slot name="trigger">
                            <x-button type="button" variant="subtle" inset="right top bottom" square data-danger>
                                <x-icon :name="Tabler::Trash" size="sm" />
                            </x-button>
                        </x-slot>

                        <x-dropdown.group>
                            <x-dropdown.text>
                                Are you sure you want to remove the
                                <strong>
                                    {{ $role->display_name ?? '' }}
                                </strong>
                                role from {{ $user->name }}?
                            </x-dropdown.text>
                        </x-dropdown.group>
                        <x-dropdown.group>
                            <x-dropdown.item
                                type="button"
                                :icon="Tabler::Trash"
                                wire:click="remove({{ $user->id }})"
                                variant="danger"
                            >
                                Remove
                            </x-dropdown.item>
                            <x-dropdown.item
                                type="button"
                                :icon="Tabler::Ban"
                                x-on:click.prevent="$dispatch('dropdown-close')"
                            >
                                Cancel
                            </x-dropdown.item>
                        </x-dropdown.group>
                    </x-dropdown>
                </div>
            </x-panel.group.row>
        @empty
            <x-empty variant="compact">
                <x-illustration :name="Illustration::Users" />
                <x-empty.heading>No users assigned</x-empty.heading>
                <x-empty.text>Get started by assigning a user this role</x-empty.text>
            </x-empty>
        @endforelse
    </x-spacing.group>

    <input type="hidden" name="assigned_users" value="{{ $assignedUsers }}" />
</x-panel>
