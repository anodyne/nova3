<div>
    <x-spacing width="sm">
        <div class="flex items-center justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Find settings</h3>

            <x-button color="neutral" wire:click="dismiss" text>
                <x-icon name="x" size="sm"></x-icon>
            </x-button>
        </div>
    </x-spacing>

    <x-spacing height="none" width="sm">
        <div>
            <x-fieldset.field>
                <x-input.text placeholder="Search for settings" wire:model.live.debounce.500ms="search" autofocus>
                    <x-slot name="leading">
                        <x-icon name="search" size="sm"></x-icon>
                    </x-slot>

                    <x-slot name="trailing">
                        @if ($search)
                            <x-button tag="button" color="neutral" wire:click="$set('search', '')" text>
                                <x-icon name="x" size="sm"></x-icon>
                            </x-button>
                        @endif
                    </x-slot>
                </x-input.text>
            </x-fieldset.field>

            <div class="mt-4 w-full max-h-60 h-60 overflow-auto bg-white text-base focus:outline-none sm:text-sm space-y-1" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                @if ($filteredSettings->count() === 0)
                    <div class="flex flex-col items-center h-60">
                        <div class="flex flex-col flex-1 justify-center text-center">
                            <x-icon name="settings" size="h-12 w-12" class="mx-auto text-gray-500"></x-icon>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No settings found</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Search for settings.
                            </p>
                        </div>
                    </div>
                @endif

                @if ($filteredSettings->count() > 0)
                    @foreach ($filteredSettings as $setting)
                        <div class="p-1.5 rounded-md odd:bg-gray-50">
                            <a href="{{ route('settings.index', $setting['route']) }}">{{ $setting['name'] }}</a>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </x-spacing>
</div>
