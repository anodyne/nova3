<x-dropdown.group>
    <x-dropdown.text>
        <x-input.group :id="$eventName" :for="$eventName" :label="$label">
            <x-input.select wire:model="selected">
                <option value="">Choose one...</option>

                @foreach ($options as $option)
                    <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                @endforeach
            </x-input.select>
        </x-input.group>
    </x-dropdown.text>
</x-dropdown.group>