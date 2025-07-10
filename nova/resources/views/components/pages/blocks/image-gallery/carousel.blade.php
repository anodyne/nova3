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

    $radius = Radius::tryFrom(data_get($block, 'carousel.radius') ?? 'none');
    $shadow = BoxShadow::tryFrom(data_get($block, 'carousel.shadow') ?? 'none');
@endphp

<x-public::block.container :$container :$content :$block class="nv-image-gallery nv-image-gallery-carousel">
    <div
        x-data="carousel({
                    intervalTime: {{ data_get($block, 'carousel.autoplay') }},
                    slides: @js($images),
                })"
        x-init="autoplay"
        x-cloak
        @class([
            'relative w-full overflow-hidden',
            $radius?->getTailwindClasses(),
            $shadow?->getTailwindClasses(),
        ])
    >
        @if (data_get($block, 'carousel.arrows') == 'yes')
            {{-- format-ignore-start --}}
            <button type="button" class="absolute left-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 items-center justify-center bg-white/10 text-white/50 p-2 transition hover:text-white/80 hover:bg-white/25" aria-label="previous slide" x-on:click="previous()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3" class="size-5 md:size-6 pr-0.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>

            <!-- next button -->
            <button type="button" class="absolute right-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 items-center justify-center bg-white/10 text-white/50 p-2 transition hover:text-white/80 hover:bg-white/25" aria-label="next slide" x-on:click="next()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3" class="size-5 md:size-6 pl-0.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
            {{-- format-ignore-end --}}
        @endif

        <div class="relative min-h-[50svh] w-full">
            <template x-for="(slide, index) in slides">
                <div
                    x-cloak
                    x-show="currentSlideIndex == index + 1"
                    class="absolute inset-0"
                    x-transition.opacity.duration.1000ms
                >
                    <div
                        class="bg-linear-to-t absolute inset-0 z-10 flex flex-col items-center justify-end gap-2 from-gray-950/85 to-transparent px-16 py-12 text-center lg:px-32 lg:py-14"
                    >
                        <h3
                            class="text-shadow-lg w-full text-balance text-2xl font-bold text-white lg:w-[80%] lg:text-3xl"
                            x-text="slide.heading"
                            x-bind:aria-describedby="'slide' + (index + 1) + 'Heading'"
                        ></h3>
                        <p
                            class="text-shadow-lg w-full text-pretty text-sm text-white/75 lg:w-1/2"
                            x-text="slide.description"
                            x-bind:id="'slide' + (index + 1) + 'Description'"
                        ></p>
                    </div>

                    <img
                        class="absolute inset-0 h-full w-full object-cover text-gray-600"
                        x-bind:src="slide.src"
                        x-bind:alt="slide.alt"
                    />
                </div>
            </template>
        </div>

        <button
            type="button"
            class="absolute bottom-5 right-5 z-20 rounded-full text-white/50 transition hover:text-white/80"
            aria-label="pause carousel"
            x-on:click="((isPaused = ! isPaused), setAutoplayInterval(autoplayIntervalTime))"
            x-bind:aria-pressed="isPaused"
        >
            {{-- format-ignore-start --}}
            <svg x-cloak x-show="isPaused" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-7"><path fill-rule="evenodd" d="M2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm6.39-2.908a.75.75 0 0 1 .766.027l3.5 2.25a.75.75 0 0 1 0 1.262l-3.5 2.25A.75.75 0 0 1 8 12.25v-4.5a.75.75 0 0 1 .39-.658Z" clip-rule="evenodd" /></svg>

            <svg x-cloak x-show="!isPaused" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-7"><path fill-rule="evenodd" d="M2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm5-2.25A.75.75 0 0 1 7.75 7h.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-.75.75h-.5a.75.75 0 0 1-.75-.75v-4.5Zm4 0a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-.75.75h-.5a.75.75 0 0 1-.75-.75v-4.5Z" clip-rule="evenodd" /></svg>
            {{-- format-ignore-end --}}
        </button>

        <div
            class="rounded-radius absolute bottom-3 left-1/2 z-20 flex -translate-x-1/2 gap-4 px-1.5 py-1 md:bottom-5 md:gap-3 md:px-2"
            role="group"
            aria-label="slides"
        >
            <template x-for="(slide, index) in slides">
                <button
                    class="size-2 rounded-full transition"
                    x-on:click="((currentSlideIndex = index + 1), setAutoplayInterval(autoplayIntervalTime))"
                    x-bind:class="[currentSlideIndex === index + 1 ? 'bg-white' : 'bg-white/50']"
                    x-bind:aria-label="'slide ' + (index + 1)"
                ></button>
            </template>
        </div>
    </div>
</x-public::block.container>
