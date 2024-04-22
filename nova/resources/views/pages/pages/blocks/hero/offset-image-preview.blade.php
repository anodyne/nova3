@php
    $color = constant('Nova\Foundation\Colors\Color::'.$ribbonColor);
@endphp

<div
    @class([
        '@container',
        'nv-hero nv-hero-offset-image',
        'dark' => $dark,
    ])
    style="
        --bgColor: {{ $backgroundColor ?? 'transparent' }};
        --lightRibbonBg: rgb({{ $color[100] }}, 0.2);
        --lightRibbonShadow: rgb({{ $color[600] }}, 0.4);
        --lightRibbonRing: rgb({{ $color[200] }}, 0.5);
        --darkRibbonBg: rgb({{ $color[950] }}, 0.2);
        --darkRibbonShadow: rgb({{ $color[900] }}, 0.4);
        --darkRibbonRing: rgb({{ $color[900] }}, 0.5);
    "
>
    <div class="nv-hero-bg-wrapper bg-[--lightBg] dark:bg-[--darkBg]">
        <div
            @class([
                'relative mx-auto max-w-7xl px-8 py-8 font-[family-name:Flow_Circular]',
                'bg-gradient-to-b from-[--lightRibbonBg] dark:from-[--darkRibbonBg]' => $bgOption === 'tailwind',
            ])
        >
            <div
                class="absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] shadow-xl shadow-[--lightRibbonShadow] ring-1 ring-[--lightRibbonRing] dark:shadow-[--darkRibbonShadow] dark:ring-[--darkRibbonRing]"
                aria-hidden="true"
            ></div>

            <div
                class="absolute inset-x-0 bottom-0 -z-10 h-32 bg-gradient-to-t from-[--lightBg] dark:from-[--darkBg]"
            ></div>

            @if (filled($calloutText))
                <div class="nv-hero-callout-ctn mt-16">
                    <x-public::preview.callout
                        href="{{ $calloutUrl ?? '#' }}"
                        :callout-color="$calloutColor ?? 'Gray'"
                    >
                        {{ $calloutText }}
                    </x-public::preview.callout>
                </div>
            @endif

            <div
                @class([
                    'grid grid-cols-1 grid-rows-1 gap-x-8',
                    'mt-10' => filled($calloutText),
                    'mt-16' => blank($calloutText),
                ])
            >
                @if (filled($heading))
                    <x-public::preview.h1 class="col-auto max-w-2xl">
                        {{ $heading }}
                    </x-public::preview.h1>
                @endif

                <div class="col-end-1 row-start-1 max-w-xl">
                    @if (filled($description))
                        <x-public::preview.lead>
                            {{ $description }}
                        </x-public::preview.lead>
                    @endif

                    @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                        <div class="nv-hero-buttons-ctn mt-10 flex flex-row items-center gap-6">
                            @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                                <x-public::preview.button :href="$primaryButtonUrl" primary>
                                    {{ $primaryButtonLabel }}
                                </x-public::preview.button>
                            @endif

                            @if (filled($secondaryButtonUrl) && filled($secondaryButtonLabel))
                                <x-public::preview.button :href="$secondaryButtonUrl">
                                    {{ $secondaryButtonLabel }}
                                </x-public::preview.button>
                            @endif
                        </div>
                    @endif
                </div>
                <img
                    src="{{ asset('media/'.$image) }}"
                    alt=""
                    class="row-span-2 row-end-2 mt-36 aspect-[6/5] w-full max-w-none rounded-2xl object-cover"
                />
            </div>
        </div>
    </div>
</div>
