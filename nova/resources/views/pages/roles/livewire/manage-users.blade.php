@use('Nova\Users\Models\User')

<div>
    <x-panel.manage>
        <x-panel.manage.search :search="$search" placeholder="Find a user to assign (type * to see all users)">
            @if ($searchResults->count() === 0)
                <x-empty-state.small icon="users" title="No user(s) found"></x-empty-state.small>
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

        @if ($users->count() > 0)
            <div
                class="divide-y divide-gray-950/5 rounded-b-lg border-t border-gray-950/5 dark:divide-white/5 dark:border-white/5"
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
                                        wire:click="remove({{ $user->id }})"
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
                icon="users"
                heading="No user(s) assigned"
                description="Get started by assigning a user this role"
            ></x-panel.manage.empty>
        @endif
    </x-panel.manage>

    <input type="hidden" name="assigned_users" value="{{ $assignedUsers }}" />
</div>
