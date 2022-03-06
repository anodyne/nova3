<x-dropdown.group>
    <x-dropdown.text>
        <x-input.group :label="$label">
            <x-input.text wire:model="value">
                @if ($value)
                    <x-slot:trailingAddOn>
                        <x-button size="none" color="gray-text" wire:click="resetValue">
                            @icon('close', 'h-5 w-5')
                        </x-button>
                    </x-slot:trailingAddOn>
                @endif
            </x-input.text>
        </x-input.group>
    </x-dropdown.text>
</x-dropdown.group>