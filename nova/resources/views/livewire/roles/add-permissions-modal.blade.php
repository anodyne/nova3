<div>
    <x-content-box width="sm">
        <h3 class="text-lg leading-6 font-medium text-gray-12" id="modal-title">Add permissions</h3>
    </x-content-box>

    <x-content-box height="none" width="sm">
        <div>
            <x-input.group>
                <x-input.text placeholder="Search for permissions" wire:model.debounce.500ms="search" autofocus>
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

            <div class="mt-4 w-full max-h-60 h-60 overflow-auto bg-gray-1 text-base focus:outline-none sm:text-sm space-y-1" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                @isset($selected)
                    @foreach ($selected as $selectedPermission)
                        <div class="p-1.5 rounded-md odd:bg-gray-3">
                            <x-input.checkbox :value="$selectedPermission" wire:model="selected">
                                <x-slot name="label">
                                    {{ $this->permissionDisplayName($selectedPermission) }}
                                </x-slot>
                            </x-input.checkbox>
                        </div>
                    @endforeach
                @endisset

                @isset($filteredPermissions)
                    @foreach ($filteredPermissions as $permission)
                        <div class="p-1.5 rounded-md odd:bg-gray-3">
                            <x-input.checkbox id="permission-{{ $permission->id }}" for="permission-{{ $permission->id }}" :value="$permission->id" :label="$permission->display_name" wire:model="selected" />
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 bg-gray-3 rounded-b-lg" height="sm" width="sm">
        <x-button color="white">Cancel</x-button>
        <x-button color="blue">Add</x-button>
    </x-content-box>
</div>
