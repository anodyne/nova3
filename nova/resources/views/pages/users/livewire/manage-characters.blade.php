@use('Nova\Characters\Models\Character')

<x-panel>
    <x-spacing size="2xs">
        <x-panel.manage.search :$search placeholder="Find a character to assign (type * to see all characters)">
            @if ($searchResults->count() === 0)
                <x-empty-state.small :icon="Icon::Characters" title="No character(s) found"></x-empty-state.small>
            @else
                <x-dropdown.group>
                    @foreach ($searchResults as $character)
                        <x-panel.manage.result-item
                            :value="$character->id"
                            :text="$character->name"
                        ></x-panel.manage.result-item>
                    @endforeach
                </x-dropdown.group>

                @can('viewAny', Character::class)
                    <x-dropdown.group>
                        <x-dropdown.text>Don’t see the character you’re looking for?</x-dropdown.text>
                        <x-dropdown.item :href="route('admin.characters.index')">
                            Go to character management &rarr;
                        </x-dropdown.item>
                    </x-dropdown.group>
                @endcan
            @endif
        </x-panel.manage.search>
    </x-spacing>

    @if ($characters->count() > 0)
        <div class="divide-y divide-gray-950/5 dark:divide-white/5">
            @foreach ($characters as $character)
                <x-spacing class="flex items-center justify-between" size="row" wire:key="row-{{ $character->id }}">
                    <div>
                        <x-avatar.character :character="$character"></x-avatar.character>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        @if ($primary?->id === $character->id)
                            <x-badge color="primary">Primary</x-badge>
                        @else
                            <x-button
                                tag="button"
                                size="xs"
                                wire:click="setAsPrimaryCharacter({{ $character->id }})"
                                outline
                            >
                                Make primary
                            </x-button>
                        @endif

                        <x-dropdown placement="bottom end">
                            <x-slot name="trigger">
                                <x-button type="button" color="neutral-danger" size="none" text>
                                    <x-icon :name="Icon::Trash" size="sm"></x-icon>
                                </x-button>
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    Are you sure you want to unassign
                                    <strong class="font-semibold">
                                        {{ $character->name }}
                                    </strong>
                                    from this user?
                                </x-dropdown.text>
                            </x-dropdown.group>
                            <x-dropdown.group>
                                <x-dropdown.item
                                    type="button"
                                    :icon="Icon::Trash"
                                    wire:click="remove({{ $character->id }})"
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
            :icon="Icon::Characters"
            heading="No character(s) assigned"
            description="Get started by assigning a character to this user"
        ></x-panel.manage.empty>
    @endif

    <input type="hidden" name="assigned_characters" value="{{ $assignedCharacters }}" />
    <input type="hidden" name="primary_character" value="{{ $primaryCharacter }}" />
</x-panel>
