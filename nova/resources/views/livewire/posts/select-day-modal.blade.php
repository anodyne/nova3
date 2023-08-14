<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="calendar" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">Add a day</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search days" wire:model.debounce.500ms="search" autofocus>
                    <x-slot>
                        <x-icon name="search" size="sm"></x-icon>
                    </x-slot>

                    <x-slot>
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
                @if ($filteredDays->count() > 0)
                    <div
                        class="mb-4 rounded-md border border-info-300 bg-info-50 px-3 py-2 font-medium text-info-600 dark:border-info-700 dark:bg-info-900/30 dark:text-info-500"
                    >
                        Don't see the day you want? Type it in the search field to add it to your post.
                    </div>
                @endif

                <div class="space-y-1">
                    @if ($day)
                        <div class="rounded-md p-1.5 odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio
                                id="day-0"
                                for="day-0"
                                :value="$day"
                                :label="$day"
                                wire:model="selected"
                                wire:key="day-0"
                            />
                        </div>
                    @endif

                    @forelse ($filteredDays as $loc)
                        <div class="rounded-md p-1.5 odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio
                                id="day-{{ $loop->iteration }}"
                                for="day-{{ $loop->iteration }}"
                                wire:key="day-{{ $loop->iteration }}"
                                :value="$loc"
                                :label="$loc"
                                wire:model="selected"
                            />
                        </div>
                    @empty
                        <div class="pt-4 text-center">
                            <div class="text-base text-gray-600 dark:text-gray-500">
                                This story does not have a day of
                            </div>
                            <div class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100">
                                &lsquo;{{ $search }}&rsquo;
                            </div>
                            <div class="mb-6 mt-4 text-sm text-gray-600 dark:text-gray-500">
                                Double-check that you've correctly spelled and capitalized the day before using it for
                                your post.
                            </div>

                            <x-button.filled wire:click="setNewDay" type="button" color="primary">
                                Use this day
                            </x-button.filled>
                        </div>
                    @endforelse

                    @if ($search && $filteredDays->count() > 0)
                        <div class="rounded-md p-1.5 odd:bg-gray-50 dark:odd:bg-gray-700/50">
                            <x-input.radio
                                id="day-999999"
                                for="day-999999"
                                wire:key="day-999999"
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

        <x-button.filled color="gray" wire:click="dismiss">Cancel</x-button.filled>
    </x-content-box>
</div>
