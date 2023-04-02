<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            @icon('calendar', 'h-6 w-6 shrink-0 text-gray-600 dark:text-gray-500')
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Add a day</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search days" wire:model.debounce.500ms="search" autofocus>
                    <x-slot:leadingAddOn>
                        @icon('search')
                    </x-slot:leadingAddOn>

                    <x-slot:trailingAddOn>
                        @if ($search)
                            <x-link tag="button" color="gray" wire:click="$set('search', '')">
                                @icon('close', 'h-5 w-5')
                            </x-link>
                        @endif
                    </x-slot:trailingAddOn>
                </x-input.text>
            </x-input.group>

            <div class="mt-4 w-full max-h-60 h-60 overflow-auto bg-white dark:bg-gray-800 text-base focus:outline-none sm:text-sm" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                @if ($filteredDays->count() > 0)
                    <div class="mb-4 rounded-md py-2 px-3 font-medium bg-info-50 dark:bg-info-900/30 border border-info-300 dark:border-info-700 text-info-600 dark:text-info-500">
                        Don't see the day you want? Type it in the search field to add it to your post.
                    </div>
                @endif

                <div class="space-y-1">
                    @if ($day)
                        <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio id="day-0" for="day-0" :value="$day" :label="$day" wire:model="selected" wire:key="day-0" />
                        </div>
                    @endif

                    @forelse ($filteredDays as $loc)
                        <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio id="day-{{ $loop->iteration }}" for="day-{{ $loop->iteration }}" wire:key="day-{{ $loop->iteration }}" :value="$loc" :label="$loc" wire:model="selected" />
                        </div>
                    @empty
                        <div class="text-center pt-4">
                            <div class="text-gray-600 dark:text-gray-500 text-base">This story does not have a day of</div>
                            <div class="text-gray-900 dark:text-gray-100 font-medium text-base mt-1">&lsquo;{{ $search }}&rsquo;</div>
                            <div class="text-gray-600 dark:text-gray-500 mt-4 mb-6 text-sm">Double-check that you've correctly spelled and capitalized the day before using it for your post.</div>

                            <x-button wire:click="setNewDay" type="button" color="primary-outline">
                                Use this day
                            </x-button>
                        </div>
                    @endforelse

                    @if ($search && $filteredDays->count() > 0)
                        <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio id="day-999999" for="day-999999" wire:key="day-999999" :value="$search" label="Use '{{ $search }}'" wire:model="selected" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        @if ($selected)
            <x-button color="primary" wire:click="apply">Apply</x-button>
        @endif

        <x-button color="white" wire:click="dismiss">Cancel</x-button>
    </x-content-box>
</div>
