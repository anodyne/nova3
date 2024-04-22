<div
    @class([
        '@container',
        'nv-hero nv-hero-split',
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
        <div
            class="nv-hero-ctn @xs:mx-auto @xs:grid-cols-1 @xs:gap-y-16 @md:gap-y-20 @xl:mx-0 @xl:max-w-none @xs:max-w-2xl grid gap-x-8 @4xl:grid-cols-2"
        >
            <div
                @class([
                    'nv-hero-content-wrapper',
                    '@xl:mr-auto @xl:pr-4 ' => isset($orientation) && $orientation === 'right',
                    '@xl:ml-auto @xl:pl-4' => isset($orientation) && $orientation === 'left',
                ])
            >
                <div class="nv-hero-content-ctn @xl:max-w-lg">
                    @if (filled($calloutText))
                        <div class="nv-callout-ctn @xs:mt-24 @md:mt-32 @xl:mt-16">
                            <x-public::callout
                                href="{{ $calloutUrl ?? '#' }}"
                                :callout-color="$calloutColor ?? 'Gray'"
                            >
                                {{ $calloutText }}
                            </x-public::callout>
                        </div>
                    @endif

                    @if (filled($heading))
                        <x-public::h1
                            @class([
                                'mt-10' => filled($calloutText),
                                '@xs:mt-24 @md:mt-32 @xl:mt-16' => blank($calloutText),
                            ])
                        >
                            {{ $heading }}
                        </x-public::h1>
                    @endif

                    @if (filled($description))
                        <x-public::lead
                            @class([
                                'mt-6' => filled($heading),
                                'mt-10' => filled($calloutText) && blank($heading),
                                '@xs:mt-24 @md:mt-32 @xl:mt-16' => blank($calloutText) && blank($heading),
                            ])
                            markdown
                        >
                            {{ $description }}
                        </x-public::lead>
                    @endif

                    @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                        <div class="nv-hero-buttons-ctn @xl:flex-row @xs:flex-col @xl:items-center mt-10 flex gap-6">
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
            </div>

            @if ($mediaType !== 'none')
                <div
                    @class([
                        'nv-hero-image-ctn flex items-end',
                        'order-last' => isset($orientation) && $orientation === 'right',
                        'order-first justify-end' => isset($orientation) && $orientation === 'left',
                    ])
                >
                    @if (isset($image) && filled($image))
                        <img
                            src="{{ asset('media/'.$image) }}"
                            alt=""
                            width="2432"
                            height="1442"
                            class="nv-hero-image w-[76rem] rounded-3xl shadow-2xl ring-1 ring-gray-900/10 dark:bg-white/5 dark:ring-white/10"
                        />
                    @endif

                    @if (isset($video) && filled($video))
                        <x-embed :url="$video"></x-embed>
                    @endif
                </div>
            @endif
        </div>
    </x-public::block.wrapper>
</div>
