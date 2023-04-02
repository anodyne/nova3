<div>
    <x-content-box>
        <x-h3>Characters assigned to this user</x-h3>

        <div class="flex justify-between mt-4">
            @if ($characters->total() > 0)
                <div class="w-full sm:w-1/3">
                    <x-input.group>
                        <x-input.text wire:model.debounce.500ms="filters.search" placeholder="Find assigned characters...">
                            <x-slot:leadingAddOn>
                                @icon('search', 'h-5 w-5')
                            </x-slot:leadingAddOn>

                            <x-slot:trailingAddOn>
                                @if ($filters['search'])
                                    <x-link tag="button" color="gray" wire:click="$set('filters.search', '')">
                                        @icon('close')
                                    </x-link>
                                @endif
                            </x-slot:trailingAddOn>
                        </x-input.text>
                    </x-input.group>
                </div>

                @can('update', $user)
                    <div class="flex items-center space-x-4">
                        @if (count($selected) > 0)
                            <x-button-outline color="danger" leading="remove" wire:click="unassignSelectedCharacters">
                                Remove {{ count($selected) }} @choice('character|characters', count($selected))
                            </x-button-outline>
                        @endif

                        <x-button-filled leading="add" wire:click="$emit('openModal', 'characters:select-characters-modal')">
                            Add characters
                        </x-button-filled>
                    </div>
                @endcan
            @endif
        </div>
    </x-content-box>

    @if ($characters->total() > 0)
        <x-table class="rounded-b-lg">
            <x-slot:head>
                @can('update', $user)
                    <x-table.heading class="pr-0 w-8 leading-0">
                        <x-input.checkbox wire:model="selectPage" />
                    </x-table.heading>
                @endcan

                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Type</x-table.heading>
                <x-table.heading>Primary</x-table.heading>
            </x-slot:head>

            <x-slot:body>
                @if ($selectPage)
                    <x-table.row>
                        <x-table.cell class="bg-primary-50" colspan="3">
                            @unless ($selectAll)
                                <div>
                                    <span class="text-primary-600">You've selected <strong>{{ $characters->count() }}</strong> characters assigned to this user. Do you want to select all <strong>{{ $characters->total() }}</strong>?</span>

                                    <x-button size="none" color="primary-text" wire:click="selectAll" class="ml-1">Select All</x-button>
                                </div>
                            @else
                                <span class="text-primary-600">You've selected all <strong>{{ $characters->total() }}</strong> characters assigned to this user.</span>
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @foreach ($characters as $character)
                    <x-table.row wire:key="row-{{ $character->id }}">
                        @can('update', $user)
                            <x-table.cell class="pr-0 leading-0">
                                <x-input.checkbox wire:model="selected" value="{{ $character->id }}" />
                            </x-table.cell>
                        @endcan

                        <x-table.cell>
                            <x-avatar.character :character="$character"></x-avatar.character>
                        </x-table.cell>

                        <x-table.cell>
                            <div>
                                <div>
                                    <x-badge :color="$character->type->color()">
                                        {{ $character->type->displayName() }}
                                    </x-badge>
                                </div>
                                @if ($character->users->count() > 0)
                                    <div class="hidden mt-2 items-center text-sm text-gray-600 dark:text-gray-400 sm:flex">
                                        @if ($character->users->count() === 1)
                                            @icon('user', 'shrink-0 mr-1.5 h-5 w-5 text-gray-500')
                                        @else
                                            @icon('users', 'shrink-0 mr-1.5 h-5 w-5 text-gray-500')
                                        @endif

                                        <span>
                                            Played by {{ $character->users->implode('name', ' & ') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </x-table.cell>

                        <x-table.cell>
                            @if ($character->type->name() === 'primary')
                                @icon('star', 'h-6 w-6 text-primary-500')
                            @else
                                <x-link tag="button" color="gray" wire:click="assignPrimaryCharacter({{ $character->id }})">
                                    @icon('star', 'h-6 w-6')
                                </x-link>
                            @endif

                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot:body>
        </x-table>

        @if ($characters->total() > $characters->perPage())
            <x-content-box class="border-t border-gray-50" height="xs">
                {{ $characters->withQueryString()->links() }}
            </x-content-box>
        @endif
    @else
        <x-content-box class="text-center">
            @icon('users', 'mx-auto h-12 w-12 text-gray-500')

            <h3 class="mt-2 text-sm font-medium text-gray-900">No characters</h3>

            @can('update', $user)
                <p class="mt-1 text-sm text-gray-600">
                    Get started by assigning characters to this user.
                </p>

                <div class="mt-6">
                    <x-button-filled wire:click="$emit('openModal', 'characters:select-characters-modal')">
                        Add characters
                    </x-button-filled>
                </div>
            @endcan
        </x-content-box>
    @endif
</div>
