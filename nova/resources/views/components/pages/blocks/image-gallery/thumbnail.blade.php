@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\Radius')

@php
    $images = collect(data_get($block, 'images'))
        ->values()
        ->map(function ($item) {
            $src = is_array($item['src'])
                ? collect($item['src'])->first()
                : $item['src'];

            $item['src'] = Storage::disk('media-pages')->url($src);

            return $item;
        });

    $radius = Radius::tryFrom(data_get($block, 'options.radius') ?? 'none');
    $shadow = BoxShadow::tryFrom(data_get($block, 'options.shadow') ?? 'none');
@endphp

<x-public::block.container :$container :$content :$block class="nv-image-gallery nv-image-gallery-thumbnail">
    <div
        class="relative w-full overflow-hidden"
        x-data="{
            slides: @js($images),
            currentSlideIndex: 0,
        }"
        x-cloak
    >
        <div
            @class([
                'relative min-h-[50svh] w-full overflow-hidden',
                $radius?->getTailwindClasses(),
                $shadow?->getTailwindClasses(),
            ])
        >
            <div
                class="bg-linear-to-t absolute inset-0 z-10 flex flex-col items-center justify-end gap-2 from-gray-950/85 to-transparent px-16 py-12 text-center lg:px-32 lg:py-14"
            >
                <h3
                    class="text-shadow-lg w-full text-balance text-2xl font-bold text-white lg:w-[80%] lg:text-3xl"
                    x-text="slides[currentSlideIndex].heading"
                    x-bind:aria-describedby="'slide' + (index + 1) + 'Heading'"
                ></h3>
                <p
                    class="text-shadow-lg w-full text-pretty text-sm text-white/75 lg:w-1/2"
                    x-text="slides[currentSlideIndex].description"
                    x-bind:id="'slide' + (index + 1) + 'Description'"
                ></p>
            </div>

            <img
                class="absolute inset-0 h-full w-full object-cover"
                x-bind:src="slides[currentSlideIndex].src"
                x-bind:alt="slides[currentSlideIndex].alt"
            />
        </div>

        <div class="relative mt-4 flex justify-center gap-4 py-1">
            <template x-for="(slide, index) in slides">
                <button
                    type="button"
                    class="h-24 w-32 overflow-hidden rounded-lg"
                    x-bind:class="{
                        'ring-2 ring-offset-2 ring-primary-500': currentSlideIndex === index,
                    }"
                    x-on:click="currentSlideIndex = index"
                >
                    <img x-bind:src="slide.src" x-bind:alt="slide.alt" class="h-full w-full object-cover" />
                </button>
            </template>
        </div>
    </div>
</x-public::block.container>
