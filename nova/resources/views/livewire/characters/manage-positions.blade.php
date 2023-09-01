<div x-on:click.away="$wire.set('search', '')">
    <x-content-box height="xs" width="xs" class="rounded-t-lg bg-gray-50 dark:bg-gray-950/30">
        <div class="flex justify-between space-x-4">
            <div class="relative w-full">
                <x-input.group>
                    <x-input.text
                        wire:model.debounce.500ms="search"
                        placeholder="Find a position to assign (type * to see all positions)"
                    >
                        <x-slot name="leading">
                            <x-icon name="search" size="sm"></x-icon>
                        </x-slot>

                        <x-slot name="trailing">
                            @if ($search)
                                <x-button.text tag="button" color="gray" wire:click="$set('search', '')">
                                    <x-icon name="dismiss" size="sm"></x-icon>
                                </x-button.text>
                            @endif
                        </x-slot>
                    </x-input.text>
                </x-input.group>

                @if (filled($search))
                    <div
                        class="absolute z-10 mt-2 max-h-60 w-full divide-y divide-gray-200 overflow-y-scroll rounded-md bg-white shadow-lg ring-1 ring-gray-950/5 dark:divide-gray-600/50 dark:bg-gray-800"
                    >
                        <x-dropdown.group>
                            @forelse ($filteredPositions as $position)
                                <x-dropdown.item
                                    type="button"
                                    class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none dark:text-gray-300 dark:hover:bg-gray-600/50 md:text-sm"
                                    wire:click="assignPosition({{ $position->id }})"
                                >
                                    {{ $position->name }}
                                    <span class="ml-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $position->available }} available
                                    </span>
                                </x-dropdown.item>
                            @empty
                                <x-empty-state.small icon="list" title="No position(s) found"></x-empty-state.small>
                            @endforelse
                        </x-dropdown.group>

                        @can('viewAny', Nova\Departments\Models\Position::class)
                            <x-dropdown.group>
                                @if ($filteredPositions->count() > 0)
                                    <x-dropdown.text>Don't see the position you're looking for?</x-dropdown.text>
                                @endif

                                <x-dropdown.item :href="route('positions.index')">
                                    Go to position management &rarr;
                                </x-dropdown.item>
                            </x-dropdown.group>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </x-content-box>

    @if ($positions->count() > 0)
        <div
            class="divide-y divide-gray-200 rounded-b-lg border-t border-gray-200 dark:divide-gray-800 dark:border-gray-800"
        >
            @foreach ($positions as $position)
                <div
                    class="flex items-center justify-between bg-white px-6 py-3 last:rounded-b-lg dark:bg-gray-900"
                    wire:key="row-{{ $position->id }}"
                >
                    <div class="truncate font-medium text-gray-900 dark:text-white">
                        {{ $position->name }}
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <x-dropdown placement="bottom-end">
                            <x-slot name="trigger" color="gray-danger">
                                <x-icon name="trash" size="sm"></x-icon>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to unassign the
                                    <strong class="font-semibold text-gray-700 dark:text-gray-200">
                                        {{ $position->name }}
                                    </strong>
                                    position?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item-danger
                                    type="button"
                                    icon="trash"
                                    wire:click="unassignPosition({{ $position->id }})"
                                >
                                    Unassign
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
        <x-content-box class="border-t border-gray-200 text-center dark:border-gray-800">
            <x-icon name="list" size="h-12 w-12" class="mx-auto text-gray-500"></x-icon>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No position(s) assigned</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Get started by assigning a position to this character
            </p>
        </x-content-box>
    @endif

    <input type="hidden" name="assigned_positions" value="{{ $assignedPositions }}" />
</div>
