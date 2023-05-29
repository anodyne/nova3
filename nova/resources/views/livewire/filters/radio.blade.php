<x-dropdown.group>
    <x-dropdown.text>
        <x-input.group>
            <x-slot:label>
                <div class="flex items-center justify-between">
                    <span>{{ $label }}</span>

                    <x-button.text wire:click="resetSelected" color="gray">
                        <x-icon name="dismiss" size="sm"></x-icon>
                        <span class="sr-only">Reset {{ $label }} filter</span>
                    </x-button.text>
                </div>
            </x-slot:label>

            <div class="flex flex-col space-y-1.5 text-base">
                @foreach ($options as $option)
                    <x-input.radio
                        for="{{ $eventName }}-{{ $option }}"
                        id="{{ $eventName }}-{{ $option }}"
                        :label="ucfirst($option)"
                        :name="$eventName"
                        :value="$option"
                        wire:model="selected"
                    />
                @endforeach
            </div>
        </x-input.group>
    </x-dropdown.text>
</x-dropdown.group>