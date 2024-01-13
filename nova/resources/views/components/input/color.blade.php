@props([
    'value' => '#0ea5e9',
])

<div data-slot="control" x-data="colorPicker('#colorPicker', '{{ $value }}')">
    <x-dropdown width="xs">
        <x-slot name="selectTrigger">
            <div class="flex items-center gap-x-3">
                <div
                    class="flex size-4 shrink-0 items-center rounded-full"
                    x-bind:style="`background-color:${color}`"
                ></div>
                <div class="flex-1 text-left" x-text="color"></div>
            </div>
        </x-slot>

        <x-dropdown.group>
            <x-dropdown.text>
                <div id="colorPicker" class="flex items-center justify-center"></div>
            </x-dropdown.text>
        </x-dropdown.group>

        <x-dropdown.group>
            <x-dropdown.text>
                <div class="flex w-full items-center gap-x-2">
                    <div class="flex-1">
                        <x-fieldset.field id="color" name="color">
                            <x-input.text {{ $attributes }} x-model="inputColor" />
                        </x-fieldset.field>
                    </div>

                    <div class="flex shrink-0 items-center">
                        <x-button type="button" x-on:click="colorPicker.color.set(inputColor)" text>
                            <x-icon name="check" size="md"></x-icon>
                        </x-button>
                    </div>
                </div>
            </x-dropdown.text>
        </x-dropdown.group>
    </x-dropdown>
</div>
