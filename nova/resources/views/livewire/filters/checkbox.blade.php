<x-dropdown.group>
    <x-dropdown.text>
        <x-input.group>
            <x-slot:label>
                <div class="flex items-center justify-between">
                    <span>{{ $label }}</span>

                    <x-button wire:click="resetSelected" size="none" color="gray-text">
                        @icon('close', 'h-5 w-5')
                        <span class="sr-only">Reset {{ $label }} filter</span>
                    </x-button>
                </div>
            </x-slot:label>

            <div class="flex flex-col space-y-1.5 text-base">
                @foreach ($options as $option)
                    <x-input.checkbox
                        for="{{ $eventName }}-{{ $option }}"
                        id="{{ $eventName }}-{{ $option }}"
                        :label="ucfirst($option)"
                        :value="$option"
                        wire:model="selected"
                    />
                @endforeach
            </div>
        </x-input.group>
    </x-dropdown.text>
</x-dropdown.group>