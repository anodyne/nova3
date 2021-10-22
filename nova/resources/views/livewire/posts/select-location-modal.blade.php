<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            @icon('location', 'h-6 w-6 flex-shrink-0 text-gray-11')
            <h3 class="text-lg leading-6 font-medium text-gray-12" id="modal-title">Add a location</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search locations" wire:model.debounce.500ms="search" autofocus>
                    <x-slot name="leadingAddOn">
                        @icon('search')
                    </x-slot>

                    <x-slot name="trailingAddOn">
                        @if ($search)
                            <x-button color="gray-text" size="none" wire:click="$set('search', '')">
                                @icon('close')
                            </x-button>
                        @endif
                    </x-slot>
                </x-input.text>
            </x-input.group>

            <div class="mt-4 w-full max-h-60 h-60 overflow-auto bg-gray-1 text-base focus:outline-none sm:text-sm" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                @if ($filteredLocations->count() > 0)
                    <div class="mb-4 rounded-md py-2 px-3 bg-purple-3 border border-purple-6 text-purple-11 font-medium">
                        Don't see the location you want? Type it in the search field to add it to your post.
                    </div>
                @endif

                <div class="space-y-1">
                    @if ($location)
                        <div class="p-1.5 rounded-md odd:bg-gray-3">
                            <x-input.radio id="location-0" for="location-0" :value="$location" :label="$location" wire:model="selected" wire:key="location-0" />
                        </div>
                    @endif

                    @forelse ($filteredLocations as $loc)
                        <div class="p-1.5 rounded-md odd:bg-gray-3">
                            <x-input.radio id="location-{{ $loop->iteration }}" for="location-{{ $loop->iteration }}" wire:key="location-{{ $loop->iteration }}" :value="$loc" :label="$loc" wire:model="selected" />
                        </div>
                    @empty
                        <div class="text-center pt-4">
                            <div class="text-gray-11 text-base">This story does not have a location of</div>
                            <div class="text-gray-12 font-medium text-base mt-1">&lsquo;{{ $search }}&rsquo;</div>
                            <div class="text-gray-11 mt-4 mb-6 text-sm">Double-check that you've correctly spelled and capitalized the location before using it for your post.</div>

                            <x-button wire:click="setNewLocation" type="button" color="blue-outline">
                                Use this location
                            </x-button>
                        </div>
                    @endforelse

                    @if ($search && $filteredLocations->count() > 0)
                        <div class="p-1.5 rounded-md odd:bg-gray-3">
                            <x-input.radio id="location-999999" for="location-999999" wire:key="location-999999" :value="$search" label="Use '{{ $search }}'" wire:model="selected" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-3 rounded-b-lg" height="sm" width="sm">
        @if ($selected)
            <x-button color="blue" wire:click="apply">Apply</x-button>
        @endif

        <x-button color="white" wire:click="dismiss">Cancel</x-button>
    </x-content-box>
</div>
