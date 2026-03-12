@use('Nova\Characters\Models\Character')

<x-panel>
    <x-spacing.group divided>
        <x-panel.group.row>
            <x-heading>Character type</x-heading>
            <div>
                <x-badge :color="$characterType->getColor()" size="md">
                    {{ $characterType->getLabel() }}
                </x-badge>
            </div>
        </x-panel.group.row>

        <x-panel.group.row class="items-start">
            <div>
                <x-heading>Character status</x-heading>

                @if ($hasReachedCharacterLimit)
                    <x-text color="warning">
                        You’ve reached the maximum allowed number of linked active characters
                        ({{ settings('characters.characterLimit') }}). In order to be activated, this character will
                        require approval by a game master.
                    </x-text>
                @elseif ($characterStatus['label'] === 'Pending')
                    <x-text color="warning">
                        This character will require approval by a game master to be activated
                    </x-text>
                @endif
            </div>
            <div>
                <x-badge :color="$characterStatus['color']" size="md">
                    {{ $characterStatus['label'] }}
                </x-badge>
            </div>
        </x-panel.group.row>

        <x-panel.group.row class="items-start">
            <div class="flex-1 space-y-8">
                <x-input.field variant="inline">
                    <x-label>Link this character to me</x-label>

                    @cannot('selfAssign', Character::class)
                        <x-description.warning>
                            Contact the game master(s) to have this character assigned to your account
                        </x-description.warning>
                    @else
                        <x-description>This character will automatically be linked to your account</x-description>
                    @endcannot

                    <x-switch
                        name="link_to_user"
                        id="link_to_user"
                        wire:model.live="linkToUser"
                        :disabled="$linkToUserDisabled"
                    />
                </x-input.field>

                <x-input.field variant="inline">
                    <x-label>Set as my primary character</x-label>

                    @cannot('assignAsPrimary', Character::class)
                        <x-description.warning>
                            Contact the game master(s) to set this character as your primary character
                        </x-description.warning>
                    @endcannot

                    <x-switch
                        name="assign_as_primary"
                        id="assign_as_primary"
                        wire:model.live="assignAsPrimary"
                        :disabled="auth()->user()->cannot(['createSecondary', 'createPrimary'], Character::class)"
                    />
                </x-input.field>
            </div>
        </x-panel.group.row>
    </x-spacing.group>
</x-panel>
