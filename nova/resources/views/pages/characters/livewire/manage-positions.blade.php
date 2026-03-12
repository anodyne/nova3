<x-panel>
    <x-spacing size="3xs" class="relative">
        <x-select
            wire:model.live.debounce="selected"
            variant="combobox"
            placeholder="Find a position to assign..."
            clearable
        >
            @foreach ($models as $model)
                <x-select.option :value="$model->id">
                    <div class="flex items-center gap-2.5">
                        <x-status :status="$model->status" />
                        {{ $model->name }}
                        <x-text variant="subtle" size="sm" class="font-normal">
                            {{ $model->available }} available
                        </x-text>
                    </div>
                </x-select.option>
            @endforeach
        </x-select>
    </x-spacing>

    <x-spacing.group divided>
        @forelse ($positions as $position)
            <x-panel.group.row wire:key="position-row-{{ $position->id }}">
                <x-heading>{{ $position->name }}</x-heading>

                <div class="flex items-center">
                    <x-dropdown placement="bottom end">
                        <x-slot name="trigger">
                            <x-button type="button" variant="subtle" inset="right top bottom" square data-danger>
                                <x-icon :name="Tabler::Trash" size="sm" />
                            </x-button>
                        </x-slot>

                        <x-dropdown.group>
                            <x-dropdown.text>
                                Are you sure you want to unassign the
                                <strong>
                                    {{ $position->name }}
                                </strong>
                                position?
                            </x-dropdown.text>
                        </x-dropdown.group>
                        <x-dropdown.group>
                            <x-dropdown.item
                                type="button"
                                :icon="Tabler::Trash"
                                wire:click="remove({{ $position->id }})"
                                variant="danger"
                            >
                                Unassign
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
            <x-empty>
                <x-illustration :name="Illustration::HandpickResume" />
                <x-empty.heading>No position(s) assigned</x-empty.heading>
                <x-empty.text>Get started by assigning a position to this character</x-empty.text>
            </x-empty>
        @endforelse
    </x-spacing.group>

    <input type="hidden" name="assigned_positions" value="{{ $assignedPositions }}" />
</x-panel>
