<x-modal.slide-over>
    <x-slot name="title">Admin theme builder</x-slot>

    <x-form action="">
        <x-fieldset.group>
            @foreach (['primary', 'danger', 'info', 'success', 'warning'] as $semanticColor)
                <div data-slot="control">
                    <x-select
                        :label="ucfirst($semanticColor)"
                        wire:model.live="{{ $semanticColor }}"
                        variant="listbox"
                    >
                        @foreach ($colors as $color)
                            <x-select.option value="{{ $color }}">
                                <div class="flex items-center gap-2">
                                    <div class="bg-{{ strtolower($color) }}-500 size-5 rounded-full"></div>

                                    {{ $color }}
                                </div>
                            </x-select.option>
                        @endforeach
                    </x-select>

                    @if ($this->isOutOfBounds($semanticColor))
                        <x-description.warning class="mt-4">
                            You’ve selected a {{ $semanticColor }} color that deviates from established user experience
                            conventions and can potentially cause confusion for users. It’s highly recommended to use a
                            color that users will expect for this type of action
                            ({{ collect($this->getInBoundsColorsFor($semanticColor))->map('strtolower')->join(', ', ', or ') }}).
                        </x-description.warning>
                    @endif
                </div>
            @endforeach

            <x-select label="Gray shade" wire:model.live="gray" variant="listbox">
                @foreach ($grays as $grayShade)
                    <x-select.option value="{{ $grayShade }}">
                        <div class="flex items-center gap-2">
                            <div class="bg-{{ strtolower($grayShade) }}-400 size-5 rounded-full"></div>

                            {{ $grayShade }}
                        </div>
                    </x-select.option>
                @endforeach
            </x-select>
        </x-fieldset.group>
    </x-form>

    <x-slot name="footer">
        <x-button type="button" wire:click="save" variant="primary">Save</x-button>
        <x-button type="button" wire:click="close" variant="ghost">Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
