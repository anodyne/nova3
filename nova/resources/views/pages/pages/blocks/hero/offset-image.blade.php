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
        <x-public::block.wrapper
            :background-type="$backgroundType ?? null"
            :background-image-intensity="$backgroundImageIntensity ?? null"
            :spacing-horizontal="$spacingHorizontal ?? null"
            :spacing-vertical="$spacingVertical ?? null"
            no-background
            @class([
                'bg-gradient-to-b from-[--lightRibbonBg] dark:from-[--darkRibbonBg]' => $bgOption === 'tailwind',
            ])
        >
            <x-slot name="beforeContainer">
                <div
                    class="@md:-mr-80 @xl:-mr-96 absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] shadow-xl shadow-[--lightRibbonShadow] ring-1 ring-[--lightRibbonRing] dark:shadow-[--darkRibbonShadow] dark:ring-[--darkRibbonRing]"
                    aria-hidden="true"
                ></div>
            </x-slot>

            <x-slot name="afterContainer">
                <div
                    class="absolute inset-x-0 bottom-0 -z-10 h-32 bg-gradient-to-t from-[--lightBg] dark:from-[--darkBg]"
                ></div>
            </x-slot>

            @if (filled($calloutText))
                <div class="nv-hero-callout-ctn @xs:mt-24 @md:mt-32 @xl:mt-16">
                    <x-public::callout href="{{ $calloutUrl ?? '#' }}" :callout-color="$calloutColor ?? 'Gray'">
                        {{ $calloutText }}
                    </x-public::callout>
                </div>
            @endif

            <div
                @class([
                    '@xs:mx-auto @xs:max-w-2xl @xl:mx-0 @xl:grid @xl:max-w-none @xl:grid-cols-2 @xl:gap-x-16 @xl:gap-y-6 @4xl:grid-cols-1 @4xl:grid-rows-1 @4xl:gap-x-8',
                    'mt-10' => filled($calloutText),
                    '@xs:mt-24 @md:mt-32 @xl:mt-16' => blank($calloutText),
                ])
            >
                @if (filled($heading))
                    <x-public::h1 class="max-w-2xl @xl:col-span-2 @4xl:col-auto">
                        {{ $heading }}
                    </x-public::h1>
                @endif

                <div class="@xl:mt-0 @xl:col-end-1 @xl:row-start-1 @xs:mt-6 max-w-xl">
                    @if (filled($description))
                        <x-public::lead markdown>
                            {{ $description }}
                        </x-public::lead>
                    @endif

                    @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                        <div class="nv-hero-buttons-ctn @xl:flex-row @xs:flex-col mt-10 flex items-center gap-6">
                            @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                                <x-public::button :href="$primaryButtonUrl" primary>
                                    {{ $primaryButtonLabel }}
                                </x-public::button>
                            @endif

                            @if (filled($secondaryButtonUrl) && filled($secondaryButtonLabel))
                                <x-public::button :href="$secondaryButtonUrl">
                                    {{ $secondaryButtonLabel }}
                                </x-public::button>
                            @endif
                        </div>
                    @endif
                </div>
                <img
                    src="{{ asset('media/'.$image) }}"
                    alt=""
                    class="@xs:mt-10 @md:mt-16 @xl:mt-0 @xs:max-w-lg @xl:max-w-none aspect-[6/5] w-full rounded-2xl object-cover @4xl:row-span-2 @4xl:row-end-2 @4xl:mt-36"
                />
            </div>
        </x-public::block.wrapper>
    </div>
</div>
