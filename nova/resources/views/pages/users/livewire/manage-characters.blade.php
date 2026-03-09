@use('Nova\Characters\Models\Character')

<x-panel>
    <x-spacing size="3xs" class="relative">
        <x-select
            wire:model.live.debounce="selected"
            variant="combobox"
            placeholder="Find a character to assign..."
            clearable
        >
            @foreach ($models as $model)
                <x-select.option :value="$model->id">
                    <div class="flex items-center gap-2.5">
                        <x-status :status="$model->status" />
                        {{ $model->display_name }}
                    </div>
                </x-select.option>
            @endforeach
        </x-select>
    </x-spacing>

    @if ($characters->count() > 0)
        <x-spacing.group divided>
            @foreach ($characters as $character)
                <x-spacing class="flex items-center justify-between" size="row" wire:key="row-{{ $character->id }}">
                    <div>
                        <x-avatar.character :$character positions />
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        @if ($primary?->id === $character->id)
                            <x-badge color="primary">Primary</x-badge>
                        @else
                            <x-button
                                size="xs"
                                wire:click="setAsPrimaryCharacter({{ $character->id }})"
                                variant="filled"
                            >
                                Make primary
                            </x-button>
                        @endif

                        <x-dropdown placement="bottom end">
                            <x-slot name="trigger">
                                <x-button type="button" variant="subtle" square>
                                    <x-icon :name="Tabler::Trash" size="sm" />
                                </x-button>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to unassign
                                    <strong>
                                        {{ $character->name }}
                                    </strong>
                                    from this user?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Tabler::Trash"
                                    wire:click="remove({{ $character->id }})"
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
                </x-spacing>
            @endforeach
        </x-spacing.group>
    @else
        <x-empty>
            <x-illustration :name="Illustration::Vulcan" />
            <x-empty.heading>No characters assigned</x-empty.heading>
            <x-empty.text>Get started by assigning a character to this user</x-empty.text>
        </x-empty>
    @endif

    <input type="hidden" name="assigned_characters" value="{{ $assignedCharacters }}" />
    <input type="hidden" name="primary_character" value="{{ $primaryCharacter }}" />
</x-panel>
