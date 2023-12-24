<x-panel class="overflow-hidden">
    <div class="divide-y divide-gray-200 dark:divide-gray-800">
        <x-content-box height="sm" class="grid grid-cols-4 gap-4 bg-white dark:bg-gray-900">
            <div class="col-span-3">
                <x-fieldset.field>
                    <x-fieldset.label>Character type</x-fieldset.label>
                </x-fieldset.field>
            </div>
            <div class="flex items-start justify-end">
                <x-badge :color="$characterType->color()">{{ $characterType->getLabel() }}</x-badge>
            </div>
        </x-content-box>

        <x-content-box height="sm" class="grid grid-cols-4 gap-4 bg-white dark:bg-gray-900">
            <div class="col-span-3">
                <x-fieldset.field>
                    <x-fieldset.label>Character status</x-fieldset.label>

                    @if ($hasReachedCharacterLimit)
                        <x-fieldset.warning-message>
                            You've reached the maximum allowed number of linked active characters
                            ({{ settings('characters.characterLimit') }}). In order to be activated, this character
                            will require approval by a game master.
                        </x-fieldset.warning-message>
                    @elseif ($characterStatus['label'] === 'Pending')
                        <x-fieldset.warning-message>
                            This character will require approval by a game master to be activated
                        </x-fieldset.warning-message>
                    @endif
                </x-fieldset.field>
            </div>
            <div class="flex items-start justify-end">
                <x-badge :color="$characterStatus['color']">{{ $characterStatus['label'] }}</x-badge>
            </div>
        </x-content-box>

        <x-content-box height="sm" class="bg-white dark:bg-gray-900">
            <x-switch.group>
                <x-switch.field>
                    <x-fieldset.label for="link_to_user">Link this character to me</x-fieldset.label>

                    @cannot('selfAssign', Nova\Characters\Models\Character::class)
                        <x-fieldset.warning-message>
                            Contact the game master(s) to have this character assigned to your account
                        </x-fieldset.warning-message>
                    @else
                        <x-fieldset.description>
                            This character will automatically be linked to your account
                        </x-fieldset.description>
                    @endcannot

                    <x-switch
                        name="link_to_user"
                        id="link_to_user"
                        wire:model.live="linkToUser"
                        :disabled="$linkToUserDisabled"
                    ></x-switch>
                </x-switch.field>

                <x-switch.field>
                    <x-fieldset.label for="assign_as_primary">Set as my primary character</x-fieldset.label>

                    @cannot('assignAsPrimary', Nova\Characters\Models\Character::class)
                        <x-fieldset.warning-message>
                            Contact the game master(s) to set this character as your primary character
                        </x-fieldset.warning-message>
                    @endcannot

                    <x-switch
                        name="assign_as_primary"
                        id="assign_as_primary"
                        wire:model.live="assignAsPrimary"
                        :disabled="auth()->user()->cannot(['createSecondary', 'createPrimary'], Nova\Characters\Models\Character::class)"
                    ></x-switch>
                </x-switch.field>
            </x-switch.group>
        </x-content-box>
    </div>
</x-panel>
