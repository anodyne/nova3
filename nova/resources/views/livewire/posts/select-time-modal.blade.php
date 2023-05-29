<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="clock" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Add a time</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search times" wire:model.debounce.500ms="search" autofocus>
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
                @if ($filteredTimes->count() > 0)
                    <div class="mb-4 rounded-md py-2 px-3 font-medium bg-secondary-50 dark:bg-secondary-900/30 border border-secondary-300 dark:border-secondary-700 text-secondary-600 dark:text-secondary-500">
                        Don't see the time you want? Type it in the search field to add it to your post.
                    </div>
                @endif

                <div class="space-y-1">
                    @if ($time)
                        <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio id="time-0" for="time-0" :value="$time" :label="$time" wire:model="selected" wire:key="time-0" />
                        </div>
                    @endif

                    @forelse ($filteredTimes as $t)
                        <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio id="time-{{ $loop->iteration }}" for="time-{{ $loop->iteration }}" wire:key="time-{{ $loop->iteration }}" :value="$t" :label="$t" wire:model="selected" />
                        </div>
                    @empty
                        <div class="text-center pt-4">
                            <div class="text-gray-600 dark:text-gray-500 text-base">This story does not have a time of</div>
                            <div class="text-gray-900 dark:text-gray-100 font-medium text-base mt-1">&lsquo;{{ $search }}&rsquo;</div>
                            <div class="text-gray-600 dark:text-gray-500 mt-4 mb-6 text-sm">Double-check that you've correctly spelled and capitalized the time before using it for your post.</div>

                            <x-button.outline wire:click="setNewTime" type="button" color="primary">
                                Use this time
                            </x-button.outline>
                        </div>
                    @endforelse

                    @if ($search && $filteredTimes->count() > 0)
                        <div class="p-1.5 rounded-md odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio id="time-999999" for="time-999999" wire:key="time-999999" :value="$search" label="Use '{{ $search }}'" wire:model="selected" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        @if ($selected)
            <x-button.filled color="primary" wire:click="apply">Apply</x-button.filled>
        @endif

        <x-button.outline color="gray" wire:click="dismiss">Cancel</x-button.outline>
    </x-content-box>
</div>
