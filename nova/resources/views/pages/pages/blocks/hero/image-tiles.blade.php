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
            class="nv-hero-ctn @xs:mx-auto @xs:max-w-2xl @xs:grid-cols-1 @xs:gap-y-16 @md:gap-y-20 grid gap-x-8 @6xl:mx-0 @6xl:max-w-none @6xl:grid-cols-2"
        >
            <div
                @class([
                    'nv-hero-content-wrapper @xl:pt-4',
                    '@xl:mr-auto @xl:pr-4 ' => $orientation === 'right',
                    '@xl:ml-auto @xl:pl-4' => $orientation === 'left',
                ])
            >
                <div class="nv-hero-content-ctn @xl:max-w-lg">
                    @if (filled($calloutText))
                        <div class="nv-hero-callout-ctn @xs:mt-24 @md:mt-32 @xl:mt-16">
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

            <div
                @class([
                    'nv-hero-image-wrapper flex items-end',
                    'order-last' => $orientation === 'right',
                    'order-first justify-end' => $orientation === 'left',
                ])
            >
                <div
                    class="nv-hero-image-ctn @xs:mt-14 @xs:justify-end @xl:-mt-44 @xl:justify-start @xl:pl-20 flex gap-8 @4xl:mt-0 @4xl:pl-0"
                >
                    <div
                        @class([
                            'w-44 flex-none space-y-8 @xs:pt-32 @xl:order-last @xl:pt-80 @4xl:pt-36 @6xl:pt-80',
                            '@xs:ml-auto @xl:ml-0 @4xl:order-none' => $orientation === 'right',
                            '@xs:mr-auto @xl:mr-0' => $orientation === 'left',
                        ])
                    >
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[0]->image) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    </div>
                    <div class="@xs:mr-auto @xl:mr-0 @xl:pt-52 w-44 flex-none space-y-8 @4xl:pt-36">
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[1]->image) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[2]->image) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    </div>

                    <div
                        @class([
                            'w-44 flex-none space-y-8 @xs:pt-32 @xl:pt-0',
                            'order-first' => $orientation === 'left',
                        ])
                    >
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[3]->image) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[4]->image) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-public::block.wrapper>
</div>
