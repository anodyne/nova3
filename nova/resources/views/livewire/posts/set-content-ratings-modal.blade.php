<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="mature" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Set content ratings</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div class="w-full max-h-80 h-80 overflow-auto bg-white dark:bg-gray-800 text-base focus:outline-none sm:text-sm" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="space-y-6">
                <x-input.group label="Language" class="w-full">
                    <livewire:rating type="language" :rating="$language" />
                </x-input.group>

                <x-input.group label="Sex" class="w-full">
                    <livewire:rating type="sex" :rating="$sex" />
                </x-input.group>

                <x-input.group label="Violence" class="w-full">
                    <livewire:rating type="violence" :rating="$violence" />
                </x-input.group>
            </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        <x-button.filled color="primary" wire:click="apply">Apply</x-button.filled>

        <x-button.outline color="gray" wire:click="dismiss">Cancel</x-button.outline>
    </x-content-box>
</div>
