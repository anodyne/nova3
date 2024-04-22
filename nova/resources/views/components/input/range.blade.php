@props([
    'size' => 'md',
])

@use('Illuminate\Support\Arr')

<div
    data-slot="control"
    x-data="tailwindScaleRange(6)"
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
            :max="scales.length - 1"
            x-model="value"
            {{ $attributes->class([
                'relative w-full cursor-pointer appearance-none bg-transparent',

                '[&::-moz-range-thumb]:-mt-0.5 [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-none [&::-moz-range-thumb]:bg-white [&::-moz-range-thumb]:ring-2 dark:[&::-moz-range-thumb]:bg-gray-900', // Thumb, Mozilla

                // '[&::-moz-range-track]:rounded-full', // Track, Mozilla

                // '[&::-ms-thumb]:-mt-0.5 [&::-ms-thumb]:appearance-none [&::-ms-thumb]:rounded-full [&::-ms-thumb]:border-none [&::-ms-thumb]:bg-white [&::-ms-thumb]:ring-2 dark:[&::-ms-thumb]:bg-gray-900', // Thumb, Edge

                // '[&::-ms-track]:rounded-full', // Track, Edge

                '[&::-webkit-slider-thumb]:-mt-0.5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border-none [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:ring-2 dark:[&::-webkit-slider-thumb]:bg-gray-900', // Thumb, Webkit

                // '[&::-webkit-slider-runnable-track]:rounded-full', // Track, Webkit

                match (settings('appearance.panda')) {
                    true => Arr::toCssClasses([
                        '[&::-moz-range-thumb]:ring-gray-900 dark:[&::-moz-range-thumb]:ring-white', // Thumb, Mozilla

                        // '[&::-moz-range-track]:[background:linear-gradient(theme(colors.gray.900),theme(colors.gray.900))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.300)] dark:[&::-moz-range-track]:[background:linear-gradient(theme(colors.white),theme(colors.white))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.700)]', // Track, Mozilla

                        // '[&::-ms-thumb]:ring-gray-900 dark:[&::-ms-thumb]:ring-white', // Thumb, Edge

                        // '[&::-ms-track]:[background:linear-gradient(theme(colors.gray.900),theme(colors.gray.900))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.300)] dark:[&::-ms-track]:[background:linear-gradient(theme(colors.white),theme(colors.white))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.700)]', // Track, Edge

                        '[&::-webkit-slider-thumb]:ring-gray-900 dark:[&::-webkit-slider-thumb]:ring-white', // Track, Webkit

                        // '[&::-webkit-slider-runnable-track]:[background:linear-gradient(theme(colors.gray.900),theme(colors.gray.900))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.300)] dark:[&::-webkit-slider-runnable-track]:[background:linear-gradient(theme(colors.white),theme(colors.white))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.700)]', // Track, Webkit
                    ]),
                    false => Arr::toCssClasses([
                        '[&::-moz-range-thumb]:ring-primary-500', // Thumb, Mozilla

                        // '[&::-moz-range-track]:[background:linear-gradient(theme(colors.primary.500),theme(colors.primary.500))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.300)] dark:[&::-moz-range-track]:[background:linear-gradient(theme(colors.primary.500),theme(colors.primary.500))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.700)]', // Track, Mozilla

                        // '[&::-ms-thumb]:ring-primary-500', // Thumb, Edge

                        // '[&::-ms-track]:[background:linear-gradient(theme(colors.primary.500),theme(colors.primary.500))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.300)] dark:[&::-ms-track]:[background:linear-gradient(theme(colors.primary.500),theme(colors.primary.500))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.700)]', // Track, Edge

                        '[&::-webkit-slider-thumb]:ring-primary-500', // Track, Webkit

                        // '[&::-webkit-slider-runnable-track]:[background:linear-gradient(theme(colors.primary.500),theme(colors.primary.500))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.300)] dark:[&::-webkit-slider-runnable-track]:[background:linear-gradient(theme(colors.primary.500),theme(colors.primary.500))_0/var(--sx)_100%_no-repeat,_theme(colors.gray.700)]', // Track, Webkit
                    ]),
                },

                match ($size) {
                    'sm' => '[&::-moz-range-thumb]:size-2.5 [&::-moz-range-track]:h-1.5 [&::-ms-thumb]:size-2.5 [&::-ms-track]:h-1.5 [&::-webkit-slider-runnable-track]:h-1.5 [&::-webkit-slider-thumb]:size-2.5',
                    'lg' => '[&::-moz-range-thumb]:size-[18px] [&::-moz-range-track]:h-3.5 [&::-ms-thumb]:size-[18px] [&::-ms-track]:h-3.5 [&::-webkit-slider-runnable-track]:h-3.5 [&::-webkit-slider-thumb]:size-[18px]',
                    default => '[&::-moz-range-thumb]:size-3.5 [&::-moz-range-track]:h-2.5 [&::-ms-thumb]:size-3.5 [&::-ms-track]:h-2.5 [&::-webkit-slider-runnable-track]:h-2.5 [&::-webkit-slider-thumb]:size-3.5',
                },
            ]) }}
        >
    </div>

    <div>
        <ul class="flex justify-between text-xs font-medium text-slate-500 px-2.5">
            <template x-for="(scale, index) in scales" :key="index">
                <li class="relative"><span class="absolute -translate-x-1/2 border-l w-px"></span></li>
            </template>
        </ul>
    </div>
</div>

@pushOnce('styles')
{{-- <style>
    input[type=range].slider-progress {
        --range: calc(var(--max) - var(--min));
        --ratio: calc((var(--value) - var(--min)) / var(--range));
        --sx: calc(0.5 * 2em + var(--ratio) * (100% - 2em));
    }
</style> --}}
@endPushOnce

@pushOnce('scripts')
{{-- <script>
    for (let e of document.querySelectorAll('input[type="range"].slider-progress')) {
        e.style.setProperty('--value', e.value);
        e.style.setProperty('--min', e.min == '' ? '0' : e.min);
        e.style.setProperty('--max', e.max == '' ? '100' : e.max);
        e.addEventListener('input', () => e.style.setProperty('--value', e.value));
    }
</script> --}}
@endPushOnce