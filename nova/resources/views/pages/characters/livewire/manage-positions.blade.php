<x-panel>
    <x-spacing size="2xs">
        <x-panel.manage.search :search="$search" placeholder="Find a position to assign (type * to see all positions)">
            <x-dropdown.group>
                @forelse ($searchResults as $position)
                    <x-panel.manage.result-item :value="$position->id">
                        <x-slot name="text">
                            <div class="flex w-full items-center justify-between">
                                {{ $position->name }}

                                <x-text class="ml-4">{{ $position->available }} available</x-text>
                            </div>
                        </x-slot>
                    </x-panel.manage.result-item>
                @empty
                    <x-empty-state.small :icon="Icon::List" title="No position(s) found"></x-empty-state.small>
                @endforelse
            </x-dropdown.group>
        </x-panel.manage.search>
    </x-spacing>

    @if ($positions->count() > 0)
        <div class="divide-y divide-gray-950/5 dark:divide-white/5">
            @foreach ($positions as $position)
                <x-spacing class="flex items-center justify-between" size="row" wire:key="row-{{ $position->id }}">
                    <div class="truncate font-medium text-gray-900 dark:text-white">
                        {{ $position->name }}
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
                                    Are you sure you want to unassign the
                                    <strong class="font-semibold">
                                        {{ $position->name }}
                                    </strong>
                                    position?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Icon::Trash"
                                    wire:click="remove({{ $position->id }})"
                                    variant="danger"
                                >
                                    Unassign
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
            :icon="Icon::List"
            heading="No position(s) assigned"
            description="Get started by assigning a position to this character"
        ></x-panel.manage.empty>
    @endif

    <input type="hidden" name="assigned_positions" value="{{ $assignedPositions }}" />
</x-panel>
