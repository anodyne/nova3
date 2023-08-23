<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="mature" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">
                Set content ratings
            </h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div
            class="h-80 max-h-80 w-full overflow-auto bg-white text-base focus:outline-none dark:bg-gray-800 sm:text-sm"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="menu-button"
            tabindex="-1"
        >
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

    <x-content-box
        class="z-20 rounded-b-lg bg-gray-50 dark:bg-gray-700/50 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse"
        height="sm"
        width="sm"
    >
        <x-button.filled color="primary" wire:click="apply">Apply</x-button.filled>
        <x-button.filled color="neutral" wire:click="dismiss">Cancel</x-button.filled>
    </x-content-box>
</div>
