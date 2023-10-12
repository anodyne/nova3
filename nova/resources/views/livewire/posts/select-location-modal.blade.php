<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="location" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">
                Add a location
            </h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search locations" wire:model.live.debounce.500ms="search" autofocus>
                    <x-slot name="leading">
                        <x-icon name="search" size="sm"></x-icon>
                    </x-slot>

                    <x-slot name="trailing">
                        @if ($search)
                            <x-button.text tag="button" color="gray" wire:click="$set('search', '')">
                                <x-icon name="dismiss" size="sm"></x-icon>
                            </x-button.text>
                        @endif
                    </x-slot>
                </x-input.text>
            </x-input.group>

            <div
                class="mt-4 h-60 max-h-60 w-full overflow-auto bg-white text-base focus:outline-none dark:bg-gray-800 sm:text-sm"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="menu-button"
                tabindex="-1"
            >
                @if ($filteredLocations->count() > 0)
                    <div
                        class="mb-4 rounded-md border border-info-300 bg-info-50 px-3 py-2 font-medium text-info-600 dark:border-info-700 dark:bg-info-900/30 dark:text-info-500"
                    >
                        Don't see the location you want? Type it in the search field to add it to your post.
                    </div>
                @endif

                <div class="space-y-1">
                    @if ($location)
                        <div class="rounded-md p-1.5 odd:bg-gray-50">
                            <x-input.radio
                                id="location-0"
                                for="location-0"
                                :value="$location"
                                :label="$location"
                                wire:model="selected"
                                wire:key="location-0"
                            />
                        </div>
                    @endif

                    @forelse ($filteredLocations as $loc)
                        <div class="rounded-md p-1.5 odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio
                                id="location-{{ $loop->iteration }}"
                                for="location-{{ $loop->iteration }}"
                                wire:key="location-{{ $loop->iteration }}"
                                :value="$loc"
                                :label="$loc"
                                wire:model="selected"
                            />
                        </div>
                    @empty
                        <div class="pt-4 text-center">
                            <div class="text-base text-gray-600 dark:text-gray-500">
                                This story does not have a location of
                            </div>
                            <div class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                                &lsquo;{{ $search }}&rsquo;
                            </div>
                            <div class="mb-6 mt-4 text-sm text-gray-600 dark:text-gray-500">
                                Double-check that you've correctly spelled and capitalized the location before using it
                                for your post.
                            </div>

                            <x-button.filled wire:click="setNewLocation" type="button" color="primary">
                                Use this location
                            </x-button.filled>
                        </div>
                    @endforelse

                    @if ($search && $filteredLocations->count() > 0)
                        <div class="rounded-md p-1.5 odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio
                                id="location-999999"
                                for="location-999999"
                                wire:key="location-999999"
                                :value="$search"
                                label="Use '{{ $search }}'"
                                wire:model="selected"
                            />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-content-box>

    <x-content-box
        class="z-20 rounded-b-lg bg-gray-50 dark:bg-gray-700/50 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse"
        height="sm"
        width="sm"
    >
        @if ($selected)
            <x-button.filled color="primary" wire:click="apply">Apply</x-button.filled>
        @endif

        <x-button.filled color="neutral" wire:click="dismiss">Cancel</x-button.filled>
    </x-content-box>
</div>
