<x-input.group>
    @isset($meta['label'])
        <x-slot:label>
            <div class="flex items-center justify-between">
                <span>{{ $meta['label'] }}</span>

                @if ($value !== $initialValue)
                    <x-button wire:click="resetValue" size="none" color="gray-text">
                        <span class="md:text-xs">Clear</span>
                    </x-button>
                @endif
            </div>
        </x-slot:label>
    @endisset

    <x-input.select wire:model="value">
        <option value="">Choose one...</option>

        @foreach ($options as $id => $option)
            <option value="{{ $this->getOptionValue($id, $option) }}">{{ $option }}</option>
        @endforeach
    </x-input.select>
</x-input.group>