<x-input.group>
    @isset($meta['label'])
        <x-slot:label>{{ $meta['label'] }}</x-slot:label>
    @endisset

    <div class="flex flex-col space-y-2 text-base">
        @foreach ($options as $id => $option)
            <x-input.checkbox
                for="{{ $this->getOptionId($option) }}"
                id="{{ $this->getOptionId($option) }}"
                :label="$option"
                :value="$this->getOptionValue($id, $option)"
                wire:model="value"
            />
        @endforeach
    </div>

    @if ($value !== $initialValue)
        <x-button.outline wire:click="resetValue" size="sm" class="mt-6 md:mt-4" color="gray">
            Reset filter
        </x-button.outline>
    @endif
</x-input.group>