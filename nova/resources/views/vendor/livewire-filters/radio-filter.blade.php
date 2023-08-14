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
        <x-button.filled wire:click="resetValue" size="sm" color="gray" class="mt-6 md:mt-4">
            Reset filter
        </x-button.filled>
    @endif
</x-input.group>