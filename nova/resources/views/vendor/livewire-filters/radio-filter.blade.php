<x-input.group>
    @isset($meta['label'])
        <x-slot:label>{{ $meta['label'] }}</x-slot:label>
    @endisset

    <div class="flex flex-col space-y-2 text-base">
        @foreach ($options as $id => $option)
            <x-input.radio
                for="{{ $this->getOptionId($option) }}"
                id="{{ $this->getOptionId($option) }}"
                :label="$option"
                :name="$this->getOptionName($option)"
                :value="$this->getOptionValue($id, $option)"
                wire:model="value"
            />
        @endforeach
    </div>

    @if ($value !== $initialValue)
        <x-button wire:click="resetValue" size="xs" class="mt-6 md:mt-4" variant="outline">
            Reset filter
        </x-button>
    @endif
</x-input.group>