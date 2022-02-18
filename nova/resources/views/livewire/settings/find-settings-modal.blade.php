<div>
    <x-content-box width="sm">
        <div class="flex items-center justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-12" id="modal-title">Find settings</h3>

            <x-button color="gray-text" size="none" wire:click="dismiss">
                @icon('close', 'h-5 w-5')
            </x-button>
        </div>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search for settings" wire:model.debounce.500ms="search" autofocus>
                    <x-slot:leadingAddOn>
                        @icon('search')
                    </x-slot:leadingAddOn>

                    <x-slot:trailingAddOn>
                        @if ($search)
                            <x-button color="gray-text" size="none" wire:click="$set('search', '')">
                                @icon('close')
                            </x-button>
                        @endif
                    </x-slot:trailingAddOn>
                </x-input.text>
            </x-input.group>

            <div class="mt-4 w-full max-h-60 h-60 overflow-auto bg-gray-1 text-base focus:outline-none sm:text-sm space-y-1" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                @if ($filteredSettings->count() === 0)
                    <div class="flex flex-col items-center h-60">
                        <div class="flex flex-col flex-1 justify-center text-center">
                            @icon('settings', 'mx-auto h-12 w-12 text-gray-9')
                            <h3 class="mt-2 text-sm font-medium text-gray-12">No settings found</h3>
                            <p class="mt-1 text-sm text-gray-11">
                                Search for settings.
                            </p>
                        </div>
                    </div>
                @endif

                @if ($filteredSettings->count() > 0)
                    @foreach ($filteredSettings as $setting)
                        <div class="p-1.5 rounded-md odd:bg-gray-3">
                            <a href="{{ route('settings.index', $setting['route']) }}">{{ $setting['name'] }}</a>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </x-content-box>
</div>
