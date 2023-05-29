<x-dropdown.group>
    <x-dropdown.text>
        <x-input.group :label="$label">
            <x-input.text wire:model="value">
                @if ($value)
                    <x-slot:trailingAddOn>
                        <x-button.text color="gray" wire:click="resetValue">
                            <x-icon name="dismiss" size="sm"></x-icon>
                        </x-button.text>
                    </x-slot:trailingAddOn>
                @endif
            </x-input.text>
        </x-input.group>
    </x-dropdown.text>
</x-dropdown.group>