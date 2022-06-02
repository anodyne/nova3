<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            @icon('mature', 'h-6 w-6 shrink-0 text-gray-600 dark:text-gray-500')
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Set content ratings</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div class="w-full max-h-60 h-60 overflow-auto bg-white dark:bg-gray-800 text-base focus:outline-none sm:text-sm" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="space-y-6">
                <x-input.group label="Language" class="w-full">
                    <x-rating :value="2" />
                </x-input.group>

                <x-input.group label="Sex" class="w-full">
                    <x-rating :value="1" />
                </x-input.group>

                <x-input.group label="Violence" class="w-full">
                    <x-rating :value="3" />
                </x-input.group>
            </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        <x-button color="blue" wire:click="apply">Apply</x-button>

        <x-button color="white" wire:click="dismiss">Cancel</x-button>
    </x-content-box>
</div>
