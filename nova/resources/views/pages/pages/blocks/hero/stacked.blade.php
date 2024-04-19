<div
    @class([
        '@container',
        'nv-hero nv-hero-stacked',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :bg-option="$bgOption"
        :bg-image-intensity="$bgImageIntensity ?? null"
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <div class="nv-hero-ctn mx-auto max-w-2xl text-center">
            @if (filled($calloutText))
                <div
                    @class([
                        'nv-hero-callout-ctn',
                        '@xs:mt-24 @lg:mt-32 @2xl:mt-16' => isset($orientation) && $orientation === 'bottom',
                    ])
                >
                    <x-public::callout href="{{ $calloutUrl ?? '#' }}" :callout-color="$calloutColor ?? 'Gray'">
                        {{ $calloutText }}
                    </x-public::callout>
                </div>
            @endif

            @if (filled($heading))
                <x-public::h1
                    @class([
                        'mt-10' => filled($calloutText),
                        '@xs:mt-24 @lg:mt-32 @2xl:mt-16' => blank($calloutText) && isset($orientation) && $orientation === 'bottom',
                    ])
                >
                    {{ $heading }}
                </x-public::h1>
            @endif

            @if (filled($description))
                <x-public::lead
                    @class([
                        'mt-6' => filled($heading),
                    ])
                    markdown
                >
                    {{ $description }}
                </x-public::lead>
            @endif

            @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                <div
                    class="nv-hero-buttons-ctn @xs:flex-col mt-10 flex items-center justify-center gap-6 @2xl:flex-row"
                >
                    @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                        <x-public::button
                            :href="$primaryButtonUrl"
                            :bg-color="$primaryButtonBgColor"
                            :text-color="$primaryButtonTextColor ?? null"
                            primary
                        >
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

        @if ($mediaType !== 'none')
            <div
                @class([
                    'nv-hero-image-ctn flow-root',
                    'order-none @xs:mt-16 @lg:mt-24' => isset($orientation) && $orientation === 'bottom',
                    'order-first @xs:mb-16 @lg:mb-24' => isset($orientation) && $orientation === 'top',
                ])
            >
                @if (isset($image) && filled($image))
                    <img
                        src="{{ asset('media/'.$image) }}"
                        alt=""
                        width="2432"
                        height="1442"
                        class="nv-hero-image rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10"
                    />
                @endif

                @if (isset($video) && filled($video))
                    <x-embed :url="$video"></x-embed>
                @endif
            </div>
        @endif
    </x-public::block.wrapper>
</div>
