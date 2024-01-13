<div>
    <x-panel.manage>
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
                    <x-empty-state.small icon="list" title="No position(s) found"></x-empty-state.small>
                @endforelse
            </x-dropdown.group>
        </x-panel.manage.search>

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
                                <x-slot name="trigger" color="neutral-danger">
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
                                        wire:click="remove({{ $position->id }})"
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
            <x-panel.manage.empty
                icon="list"
                heading="No position(s) assigned"
                description="Get started by assigning a position to this character"
            ></x-panel.manage.empty>
        @endif
    </x-panel.manage>

    <input type="hidden" name="assigned_positions" value="{{ $assignedPositions }}" />
</div>
