<x-panel x-data="filtersPanel()" x-bind="parent">
    <x-content-box height="sm" class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8">
        <div class="flex-1">
            <x-input.group>
                <x-input.text placeholder="Find users by name, email, or assigned character(s) name..." wire:model="search">
                    <x-slot:leadingAddOn>
                        @icon('search', 'h-5 w-5')
                    </x-slot:leadingAddOn>

                    @if ($search)
                        <x-slot:trailingAddOn>
                            <x-button size="none" color="gray-text" wire:click="$set('search', '')">
                                @icon('close', 'h-5 w-5')
                            </x-button>
                        </x-slot:trailingAddOn>
                    @endif
                </x-input.text>
            </x-input.group>
        </div>

        <div class="shrink flex justify-between md:justify-start items-center space-x-4">
            <x-button type="button" size="none" :color="$isFiltered ? 'blue-text' : 'gray-text'" x-bind="trigger">
                <div class="flex items-center space-x-2">
                    @icon('filter', 'h-5 w-5')
                    <span>Filters</span>
                    @if ($activeFilterCount > 0)
                        <x-badge color="blue" size="xs">{{ $activeFilterCount }}</x-badge>
                    @endif
                </div>
            </x-button>
        </div>
    </x-content-box>

    <x-panel.filters x-bind="panel" x-cloak>
        <livewire:livewire-filters-checkbox :filter="$filters['status']" />

        <livewire:livewire-filters-radio :filter="$filters['assigned_characters']" />
    </x-panel.filters>

    <ul class="divide-y divide-gray-6">
        @if ($users->total() > 0)
            <li class="hidden md:block border-t border-gray-6 bg-gray-2 text-xs leading-4 font-semibold text-gray-9 uppercase tracking-wider">
                <div class="block">
                    <x-content-box height="xs" class="flex">
                        <div class="min-w-0 flex-1 grid grid-cols-5 gap-4">
                            <div class="col-span-2">Name</div>
                            <div class="col-span-2">Recent Activity</div>
                            <div>Status</div>
                        </div>
                        <div class="block ml-4 w-6"></div>
                    </x-content-box>
                </div>
            </li>
        @endif

        @forelse ($users as $user)
            <li>
                <div class="block hover:bg-gray-2 focus:outline-none focus:bg-gray-2 transition duration-200 ease-in-out">
                    <x-content-box height="sm" class="flex">
                        <div class="min-w-0 flex-1 grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="md:col-span-2">
                                <x-avatar-meta :src="$user->avatar_url">
                                    <x-slot:primaryMeta>{{ $user->name }}</x-slot:primaryMeta>
                                </x-avatar-meta>
                            </div>

                            <div class="md:col-span-2">
                                <div class="space-y-2">
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
                                        <div class="flex items-center text-sm text-gray-11">
                                            @icon('sign-in', 'shrink-0 mr-1.5 h-5 w-5 text-gray-9')
                                            Last signed in&nbsp;
                                            <time datetime="{{ $user->latestLogin->created_at }}">
                                                {{ $user->latestLogin->created_at?->diffForHumans() }}
                                            </time>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center">
                                <x-badge size="xs" :color="$user->status->color()">
                                    {{ $user->status->displayName() }}
                                </x-badge>
                            </div>
                        </div>

                        <div class="ml-4 flex md:items-center">
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
                    </x-content-box>
                </div>
            </li>
        @empty
            <li class="border-t border-gray-6">
                <x-search-not-found>
                    No users found
                </x-search-not-found>
            </li>
        @endforelse
    </ul>

    <x-content-box height="xs" class="border-t border-gray-6">
        {{ $users->withQueryString()->links() }}
    </x-content-box>
</x-panel>