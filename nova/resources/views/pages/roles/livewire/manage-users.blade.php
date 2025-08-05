@use('Nova\Users\Models\User')

<x-panel>
    <x-spacing size="2xs">
        <x-panel.manage.search :$search placeholder="Find a user to assign (type * to see all users)">
            @if ($searchResults->count() === 0)
                <x-empty-state.small :icon="Icon::Users" title="No user(s) found"></x-empty-state.small>
            @else
                <x-dropdown.group>
                    @foreach ($searchResults as $user)
                        <x-panel.manage.result-item
                            :value="$user->id"
                            :text="$user->name"
                        ></x-panel.manage.result-item>
                    @endforeach
                </x-dropdown.group>

                @can('viewAny', User::class)
                    <x-dropdown.group>
                        <x-dropdown.text>Don’t see the user you're looking for?</x-dropdown.text>
                        <x-dropdown.item :href="route('admin.users.index')">
                            Go to user management &rarr;
                        </x-dropdown.item>
                    </x-dropdown.group>
                @endcan
            @endif
        </x-panel.manage.search>
    </x-spacing>

    @if ($users->count() > 0)
        <div class="divide-y divide-gray-950/5 dark:divide-white/5">
            @foreach ($users as $user)
                <x-spacing class="flex items-center justify-between" size="row" wire:key="row-{{ $user->id }}">
                    <div class="flex items-center gap-x-3 truncate font-medium text-gray-950 dark:text-white">
                        <x-status :status="$user->status"></x-status>
                        <span>{{ $user->name }}</span>
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
                                        {{ $role->display_name ?? '' }}
                                    </strong>
                                    role from {{ $user->name }}?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Icon::Trash"
                                    wire:click="remove({{ $user->id }})"
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
            :icon="Icon::Users"
            heading="No user(s) assigned"
            description="Get started by assigning a user this role"
        ></x-panel.manage.empty>
    @endif

    <input type="hidden" name="assigned_users" value="{{ $assignedUsers }}" />
</x-panel>
