<x-panel>
    <x-content-box height="sm" class="flex items-center space-x-8">
        <div class="flex-1">
            <x-input.group>
                <x-input.text placeholder="Search for user" wire:model="search">
                    <x-slot:leadingAddOn>
                        @icon('search', 'h-5 w-5')
                    </x-slot:leadingAddOn>
                </x-input.text>
            </x-input.group>
        </div>
        <div class="shrink">
            <x-dropdown trigger-size="md" trigger-color="white" placement="bottom-end">
                <x-slot:trigger>
                    <div class="flex items-center space-x-2">
                        @icon('filter', 'h-5 w-5')
                        <span>Filters</span>
                    </div>
                </x-slot:trigger>

                <x-dropdown.group>
                    <x-dropdown.text>User Type</x-dropdown.text>
                    <x-dropdown.text class="flex flex-col space-y-1">
                        @foreach (Nova\Users\Models\User::getStatesFor('status') as $status)
                            <x-input.checkbox
                                for="type-{{ $status }}"
                                id="type-{{ $status }}"
                                :label="ucfirst($status)"
                                :value="$status"
                                wire:model="filters.status"
                            />
                        @endforeach
                    </x-dropdown.text>
                </x-dropdown.group>
            </x-dropdown>

            {{-- <x-input.select>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="pending">Pending</option>
                <option value="">All users</option>
            </x-input.select> --}}
        </div>
        <div class="shrink">
            <x-button size="none" color="gray-text">Clear all</x-button>
        </div>
    </x-content-box>

    <ul>
        <li class="border-t border-gray-6 bg-gray-2 text-xs leading-4 font-semibold text-gray-9 uppercase tracking-wider">
            <div class="block">
                <div class="flex items-center px-4 py-3 sm:px-6">
                    <div class="min-w-0 flex-1 pr-4 md:grid md:grid-cols-2 md:gap-4">
                        Name

                        <div class="hidden md:block">
                            Activity
                        </div>
                    </div>
                    <div class="w-6"></div>
                </div>
            </div>
        </li>
        @forelse ($users as $user)
            <li class="border-t border-gray-6">
                <div class="block hover:bg-gray-2 focus:outline-none focus:bg-gray-2 transition duration-200 ease-in-out">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="min-w-0 flex-1 pr-4 md:grid md:grid-cols-2 md:gap-4">
                            <x-avatar-meta :src="$user->avatar_url">
                                <x-slot:primaryMeta>{{ $user->name }}</x-slot:primaryMeta>

                                <x-slot:secondaryMeta>
                                    <x-badge size="xs" :color="$user->status->color()">
                                        {{ $user->status->displayName() }}
                                    </x-badge>
                                </x-slot:secondaryMeta>
                            </x-avatar-meta>

                            <div class="hidden md:block">
                                <div>
                                    @if ($user->updated_at !== null)
                                        <div class="flex items-center text-sm text-gray-11">
                                            @icon('clock', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                            Last activity&nbsp;
                                            <time datetime="{{ $user->updated_at }}">
                                                {{ $user->updated_at?->diffForHumans() }}
                                            </time>
                                        </div>
                                    @endif
                                    @if ($user->latestLogin !== null)
                                        <div class="mt-2 flex items-center text-sm text-gray-11">
                                            @icon('sign-in', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                            Last signed in&nbsp;
                                            <time datetime="{{ $user->latestLogin->created_at }}">
                                                {{ $user->latestLogin->created_at?->diffForHumans() }}
                                            </time>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <x-dropdown placement="bottom-end">
                                <x-slot:trigger>
                                    <x-icon.more class="h-6 w-6" />
                                </x-slot:trigger>

                                <x-dropdown.group>
                                    @can('view', $user)
                                        <x-dropdown.item :href="route('users.show', $user)" icon="show" data-cy="view">
                                            <span>View</span>
                                        </x-dropdown.item>
                                    @endcan

                                    @can('update', $user)
                                        <x-dropdown.item :href="route('users.edit', $user)" icon="edit" data-cy="edit">
                                            <span>Edit</span>
                                        </x-dropdown.item>
                                    @endcan
                                </x-dropdown.group>

                                @can('activate', $user)
                                    <x-dropdown.group>
                                        <x-dropdown.item type="submit" id="check-alt" form="activate" data-cy="activate">
                                            <span>Activate</span>

                                            <x-slot:buttonForm>
                                                <x-form :action="route('users.activate', $user)" id="activate" />
                                            </x-slot:buttonForm>
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                @endcan

                                @can('deactivate', $user)
                                    <x-dropdown.group>
                                        <x-dropdown.item type="button" icon="remove" @click="$dispatch('dropdown-toggle');$dispatch('modal-deactivate', {{ json_encode($user) }});" form="deactivate" data-cy="deactivate">
                                            <span>Deactivate</span>
                                        </x-dropdown.item>
                                    </x-dropdown.group>
                                @endcan

                                @can('delete', $user)
                                    <x-dropdown.group>
                                        <x-dropdown.item-danger type="button" icon="delete" @click="$dispatch('dropdown-toggle');$dispatch('modal-load', {{ json_encode($user) }});" data-cy="delete">
                                            <span>Delete</span>
                                        </x-dropdown.item-danger>
                                    </x-dropdown.group>
                                @endcan
                            </x-dropdown>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <x-search-not-found>
                No users found
            </x-search-not-found>
        @endforelse
    </ul>

    <div class="px-4 py-2 border-t border-gray-6 sm:px-6 sm:py-3">
        {{ $users->withQueryString()->links() }}
    </div>
</x-panel>