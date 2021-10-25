<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            @icon('book', 'h-6 w-6 flex-shrink-0 text-gray-11')
            <h3 class="text-lg leading-6 font-medium text-gray-12" id="modal-title">Choose a story</h3>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search stories" wire:model.debounce.500ms="search" autofocus>
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
                <div class="space-y-1">
                    @if ($filteredStories->count() > 0)
                        @foreach ($filteredStories as $s)
                            <div class="p-1.5 rounded-md odd:bg-gray-3">
                                <x-input.radio id="story-{{ $s->id }}" for="story-{{ $s->id }}" :value="$s->id" :label="$s->title" wire:model="selected" />
                            </div>
                        @endforeach
                    @endisset
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
