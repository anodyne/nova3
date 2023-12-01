<x-panel class="overflow-hidden">
    <div class="divide-y divide-gray-200 dark:divide-gray-800">
        <x-content-box height="sm" class="grid grid-cols-4 gap-4 bg-white dark:bg-gray-900">
            <div class="col-span-3 font-medium text-gray-900 dark:text-gray-100">Character type</div>
            <div class="flex items-start justify-end">
                <x-badge :color="$characterType->color()">{{ $characterType->getLabel() }}</x-badge>
            </div>
        </x-content-box>

        <x-content-box height="sm" class="grid grid-cols-4 gap-4 bg-white dark:bg-gray-900">
            <div class="col-span-3 font-medium text-gray-900 dark:text-gray-100">
                Character status

                @if ($hasReachedCharacterLimit)
                    <div class="mt-1 text-sm font-normal text-gray-500">
                        You've reached the maximum allowed number of linked active characters
                        ({{ settings('characters.characterLimit') }}). In order to be activated, this character will
                        require approval by a game master.
                    </div>
                @elseif ($characterStatus['label'] === 'Pending')
                    <div class="mt-1 text-sm font-normal text-gray-500">
                        This character will require approval by a game master to be activated
                    </div>
                @endif
            </div>
            <div class="flex items-start justify-end">
                <x-badge :color="$characterStatus['color']">{{ $characterStatus['label'] }}</x-badge>
            </div>
        </x-content-box>

        <x-content-box height="sm" class="grid grid-cols-4 gap-4 bg-white dark:bg-gray-900">
            <div class="col-span-3 font-medium text-gray-900 dark:text-gray-100">
                Link this character to me

                @cannot('selfAssign', Nova\Characters\Models\Character::class)
                    <div class="mt-1 text-sm font-normal text-gray-500">
                        Contact the game master(s) to have this character assigned to your account
                    </div>
                @endcannot
            </div>
            <div class="flex items-start justify-end">
                {{--
                    <x-switch-toggle
                    name="link_to_user"
                    wire:model.live="linkToUser"
                    :disabled="$linkToUserDisabled"
                    ></x-switch-toggle>
                --}}
                <x-input.toggle
                    name="link_to_user"
                    wire:model.live="linkToUser"
                    :disabled="$linkToUserDisabled"
                ></x-input.toggle>
            </div>
        </x-content-box>

        <x-content-box height="sm" class="grid grid-cols-4 gap-4 bg-white dark:bg-gray-900">
            <div class="col-span-3 font-medium text-gray-900 dark:text-gray-100">
                Set as my primary character

                @cannot('assignAsPrimary', Nova\Characters\Models\Character::class)
                    <div class="mt-1 text-sm font-normal text-gray-500">
                        Contact the game master(s) to set this character as your primary character
                    </div>
                @endcannot
            </div>
            <div class="flex items-start justify-end">
                {{--
                    <x-switch-toggle
                    name="assign_as_primary"
                    wire:model.live="assignAsPrimary"
                    :disabled="auth()->user()->cannot(['createSecondary', 'createPrimary'], Nova\Characters\Models\Character::class)"
                    ></x-switch-toggle>
                --}}
                <x-input.toggle
                    name="assign_as_primary"
                    wire:model.live="assignAsPrimary"
                    :disabled="auth()->user()->cannot(['createSecondary', 'createPrimary'], Nova\Characters\Models\Character::class)"
                ></x-input.toggle>
            </div>
        </x-content-box>
    </div>
</x-panel>
