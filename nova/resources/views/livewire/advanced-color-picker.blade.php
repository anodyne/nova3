<x-fieldset.field-group>
    <x-fieldset.field>
        <x-fieldset.label>
            <div class="flex items-center justify-between">
                Shade
                <span class="font-normal text-xs/5 text-gray-500">{{ $shade }}</span>
            </div>
        </x-fieldset.label>

        <div
            data-slot="control"
            x-data="{
                value: @entangle('shade').live,
                valueKey: null,
                scales: [
                    { label: '50' },
                    { label: '100' },
                    { label: '200' },
                    { label: '300' },
                    { label: '400' },
                    { label: '500' },
                    { label: '600' },
                    { label: '700' },
                    { label: '800' },
                    { label: '900' },
                    { label: '950' },
                ],
                segmentsWidth: '100%',
                progress: '0%',
                segments: 1,

                calculateProgress() {
                    this.value = this.scales[this.valueKey].label;
                    this.segmentsWidth = `${100 / this.segments}%`;
                    this.progress = `${(100 / this.segments) * this.valueKey}%`;
                    this.$dispatch('input', this.value);
                },

                getValueKey() {
                    return this.scales.findIndex(scale => scale.label == this.value);
                },

                shouldShowMarker(scaleValue) {
                    return ['50', '500', '950'].indexOf(scaleValue) >= 0;
                },

                init() {
                    this.valueKey = this.getValueKey();
                    this.segments = this.scales.length - 1;
                    this.calculateProgress();
                    this.$watch('valueKey', () => this.calculateProgress());
                },
            }"
        >
            <div
                class="relative flex items-center"
                :style="`--progress:${progress};--segments-width:${segmentsWidth}`;"
            >
                <div
                    @class([
                        'absolute left-2.5 right-2.5 h-2.5 overflow-hidden rounded-full bg-gray-200',
                        'before:absolute before:inset-0 [&[x-cloak]]:hidden',
                        'before:bg-gradient-to-r',
                        'before:[mask-image:_linear-gradient(to_right,theme(colors.white),theme(colors.white)_var(--progress),transparent_var(--progress))]',
                        'before:from-primary-500 before:to-primary-500' => ! settings('appearance.panda'),
                        'before:from-gray-900 before:to-gray-900' => settings('appearance.panda'),
                    ])
                    x-cloak
                ></div>

                <input
                    type="range"
                    min="0"
                    x-bind:max="scales.length - 1"
                    x-model="valueKey"
                    @class([
                        'relative w-full cursor-pointer appearance-none bg-transparent',
                        '[&::-moz-range-thumb]:-mt-0.5 [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-none [&::-moz-range-thumb]:bg-white [&::-moz-range-thumb]:ring-2 dark:[&::-moz-range-thumb]:bg-gray-900', // Thumb, Mozilla
                        '[&::-webkit-slider-thumb]:-mt-0.5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border-none [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:ring-2 dark:[&::-webkit-slider-thumb]:bg-gray-900', // Thumb, Webkit

                        match (settings('appearance.panda')) {
                            true => Arr::toCssClasses([
                                '[&::-moz-range-thumb]:ring-gray-900 dark:[&::-moz-range-thumb]:ring-white', // Thumb, Mozilla
                                '[&::-webkit-slider-thumb]:ring-gray-900 dark:[&::-webkit-slider-thumb]:ring-white', // Track, Webkit
                            ]),
                            false => Arr::toCssClasses([
                                '[&::-moz-range-thumb]:ring-primary-500', // Thumb, Mozilla
                                '[&::-webkit-slider-thumb]:ring-primary-500', // Track, Webkit
                            ]),
                        },

                        '[&::-moz-range-thumb]:size-3.5 [&::-moz-range-track]:h-2.5 [&::-ms-thumb]:size-3.5 [&::-ms-track]:h-2.5 [&::-webkit-slider-runnable-track]:h-2.5 [&::-webkit-slider-thumb]:size-3.5',
                    ])
                >
            </div>
        </div>
    </x-fieldset.field>

    <x-fieldset.field>
        <x-fieldset.label>
            <div class="flex items-center justify-between">
                <div>Pre-defined colors</div>
                <div class="text-xs/5 font-normal text-gray-500">{{ str($color)->title() }}</div>
            </div>
        </x-fieldset.label>

        <div
            data-slot="control"
            class="grid grid-cols-6 gap-x-3 gap-y-3"
        >
            @foreach ($colors as $key => $c)
                <label
                    style="background-color: rgba({{ $c[$shade] }}, 1);"
                    @class([
                        'size-8 cursor-pointer rounded-full border border-black/10',
                        'ring-2 ring-blue-500 ring-offset-2 ring-offset-white dark:ring-offset-gray-900' => $key === $color,
                    ])
                >
                    <input
                        type="radio"
                        wire:model.live="color"
                        value="{{ $key }}"
                        class="opacity-0 pointer-events-none"
                    />
                    <span class="sr-only">{{ str($key)->title() }}</span>
                </label>
            @endforeach
        </div>
    </x-fieldset.field>

    <x-fieldset.field label="Color" id="color" name="color">
        <span
            data-slot="control"
            @class([
                // Basic layout
                'relative flex w-full gap-x-2',

                // Background color + shadow applied to inset pseudo element, so shadow blends with border in light mode
                'before:absolute before:inset-px before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-white before:shadow',

                // Background color is moved to control and shadow is removed in dark mode so hide `before` pseudo
                'dark:before:hidden',

                // Focus ring
                'after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:ring-inset after:ring-transparent sm:after:focus-within:ring-2',

                'sm:after:focus-within:ring-primary-500' => ! settings('appearance.panda'),
                'sm:after:focus-within:ring-gray-900 dark:sm:after:focus-within:ring-gray-500' => settings('appearance.panda'),

                // Disabled state
                'has-[[data-disabled]]:opacity-50 before:has-[[data-disabled]]:bg-gray-950/5 before:has-[[data-disabled]]:shadow-none',

                // Invalid state
                'before:has-[[data-invalid]]:shadow-danger-500/10',
            ])
        >
            <label
                for="{{ $field }}"
                @class([
                    // Basic layout
                    'relative flex w-full appearance-none items-center gap-x-2 rounded-lg px-1.5 py-1.5',

                    // Typography
                    'text-base/6 text-gray-950 placeholder:text-gray-500 dark:text-white sm:text-sm/6',

                    // Border
                    'border border-gray-950/10 hover:border-gray-950/20 dark:border-white/10 dark:hover:border-white/20',

                    // Background color
                    'bg-transparent dark:bg-white/5',

                    // Hide default focus styles
                    'focus:outline-none focus:ring-0',
                ])
            >
                <input
                    type="color"
                    id="{{ $field }}"
                    name="{{ $field }}"
                    wire:model.live="state"
                    @class([
                        'size-7 cursor-pointer rounded',
                        '[&::-webkit-color-swatch-wrapper]:border-none [&::-webkit-color-swatch-wrapper]:p-0',
                        '[&::-webkit-color-swatch]:rounded [&::-webkit-color-swatch]:border [&::-webkit-color-swatch]:border-black/10',
                        '[&::-moz-color-swatch]:rounded [&::-moz-color-swatch]:border [&::-moz-color-swatch]:border-black/10',
                    ])
                >
                <div>{{ $state }}</div>
            </label>
        </span>
    </x-fieldset.field>
</x-fieldset.field-group>
