<div>
    <x-content-box>
        <div class="flex justify-between">
            <div>
                <h3 class="font-bold text-xl text-gray-12 tracking-tight">Users Assigned this Role</h3>
                <p class="mt-1 text-gray-10 space-y-6">You can manage the users who are assigned this role from here.</p>
            </div>

            @if ($users->total() > 0)
                <div class="flex items-center space-x-2">
                    @if (count($selected) > 0)
                        <x-button color="red-soft" size="xs" wire:click="unassignSelectedUsers">
                            Remove {{ count($selected) }} @choice('user|users', count($selected))
                        </x-button>
                    @endif

                    <x-button type="button" size="xs" wire:click="$emit('openModal', 'users:select-users-modal')">
                        Add users
                    </x-button>
                </div>
            @endif
        </div>
    </x-content-box>

    @if ($users->total() > 0)
        <x-table class="rounded-b-lg">
            <x-slot name="head">
                <x-table.heading class="pr-0 w-8 leading-0">
                    <x-input.checkbox wire:model="selectPage" />
                </x-table.heading>
                <x-table.heading>Name</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row>
                        <x-table.cell class="bg-blue-3" colspan="3">
                            @unless ($selectAll)
                                <span class="text-blue-11">You've selected <strong>{{ $users->count() }}</strong> users assigned this role. Do you want to select all <strong>{{ $users->total() }}</strong>?</span>

                                <x-button size="none" color="blue-text" wire:click="selectAll" class="ml-1">Select All</x-button>
                            @else
                                <span class="text-blue-11">You've selected all <strong>{{ $users->total() }}</strong> users assigned this role.</span>
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @foreach ($users as $user)
                    <x-table.row wire:key="row-{{ $user->id }}">
                        <x-table.cell class="pr-0 leading-0">
                            <x-input.checkbox wire:model="selected" value="{{ $user->id }}" />
                        </x-table.cell>
                        <x-table.cell>
                            <x-avatar-meta :src="$user->avatar_url">
                                <x-slot name="primaryMeta">{{ $user->name }}</x-slot>

                                <x-slot name="secondaryMeta">
                                    <x-badge size="xs" :color="$user->status->color()">
                                        {{ $user->status->displayName() }}
                                    </x-badge>
                                </x-slot>
                            </x-avatar-meta>
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot>
        </x-table>

        @if ($users->total() > $users->perPage())
            <x-content-box class="border-t border-gray-3" height="xs">
                {{ $users->withQueryString()->links() }}
            </x-content-box>
        @endif
    @else
        <x-content-box class="text-center">
            @icon('users', 'mx-auto h-12 w-12 text-gray-9')

            <h3 class="mt-2 text-sm font-medium text-gray-12">No users</h3>

            <p class="mt-1 text-sm text-gray-11">
                Get started by assigning users this role.
            </p>

            <div class="mt-6">
                <x-button color="blue" wire:click="$emit('openModal', 'users:select-users-modal')">
                    Add users
                </x-button>
            </div>
        </x-content-box>
    @endif
</div>
