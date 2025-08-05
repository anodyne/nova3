<x-modal.slide-over>
    <x-slot name="title">Theme builder</x-slot>

    <x-form action="">
        <x-fieldset.field-group>
            @foreach (['primary', 'danger', 'info', 'success', 'warning'] as $semanticColor)
                <x-fieldset.field
                    label="{{ ucfirst($semanticColor) }} color"
                    id="{{ $semanticColor }}_color"
                    name="{{ $semanticColor }}_color"
                >
                    <div class="flex items-center gap-3" data-slot="control">
                        <x-select wire:model.live="{{ $semanticColor }}">
                            @foreach ($colors as $color)
                                <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </x-select>

                        <div class="flex shrink-0 items-center">
                            <div class="bg-{{ strtolower($$semanticColor) }}-500 size-6 rounded-full"></div>
                        </div>
                    </div>

                    @if ($this->isOutOfBounds($semanticColor))
                        <x-fieldset.description class="pr-9">
                            You‘ve selected a {{ $semanticColor }} color that deviates from established user experience
                            conventions. This can potentially cause confusion for users. Use caution when using this
                            {{ $semanticColor }} color.
                        </x-fieldset.description>
                    @endif
                </x-fieldset.field>
            @endforeach

            <x-fieldset.field label="Gray shade" id="gray_color" name="gray_color">
                <div class="flex items-center gap-3" data-slot="control">
                    <x-select wire:model.live="gray">
                        @foreach ($grays as $grayShade)
                            <option value="{{ $grayShade }}">{{ $grayShade }}</option>
                        @endforeach
                    </x-select>

                    <div class="flex shrink-0 items-center">
                        <div class="bg-{{ strtolower($gray) }}-400 size-6 rounded-full"></div>
                    </div>
                </div>
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-form>

    <x-slot name="footer">
        <x-button type="button" wire:click="save" color="primary">Save</x-button>
        <x-button type="button" wire:click="close" plain>Cancel</x-button>
    </x-slot>
</x-modal.slide-over>
