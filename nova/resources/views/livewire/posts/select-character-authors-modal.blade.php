<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="users" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Add characters</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Find characters" wire:model.debounce.500ms="search" autofocus>
                    <x-slot:leadingAddOn>
                        <x-icon name="search" size="sm"></x-icon>
                    </x-slot:leadingAddOn>

                    <x-slot:trailingAddOn>
                        @if ($search)
                            <x-button.text tag="button" color="gray" wire:click="$set('search', '')">
                                <x-icon name="dismiss" size="sm"></x-icon>
                            </x-button.text>
                        @endif
                    </x-slot:trailingAddOn>
                </x-input.text>
            </x-input.group>

            <div class="mt-4 w-full max-h-60 h-60 overflow-auto bg-white dark:bg-gray-800 text-base focus:outline-none sm:text-sm" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="space-y-1">
                    @if (count($selected) === 0 && $characters->count() === 0)
                        <div class="flex flex-col items-center h-60">
                            <div class="flex flex-col flex-1 justify-center text-center">
                                <x-icon name="users" size="h-12 w-12" class="mx-auto text-gray-500"></x-icon>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No characters selected</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Search for characters to add to this post.
                                </p>
                            </div>
                        </div>
                    @endif

                    @if (count($selectedDisplay) > 0)
                        @foreach ($selectedDisplay as $id => $name)
                            <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                                <x-input.checkbox :value="$id" :label="$name" wire:model="selected"></x-input.checkbox>
                            </div>
                        @endforeach
                    @endif

                    @if ($characters->count() > 0)
                        @foreach ($characters as $character)
                            <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                                <x-input.checkbox id="character-{{ $character->id }}" for="character-{{ $character->id }}" :value="$character->id" :label="$character->name" wire:model="selected"></x-input.checkbox>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        @if (count($selected) > 0)
            <x-button.filled color="primary" wire:click="apply">Apply</x-button.filled>
        @endif

        <x-button.filled color="neutral" wire:click="dismiss">Cancel</x-button.filled>
    </x-content-box>
</div>
