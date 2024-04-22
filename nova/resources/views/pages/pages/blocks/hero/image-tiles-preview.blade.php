<div @class([
    'not-prose',
    'bg-white' => ! $dark,
    'dark bg-gray-900' => $dark,
])>
    <div class="mx-auto max-w-7xl px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="nv-hero-ctn grid max-w-none grid-cols-2 gap-x-8 gap-y-20">
            <div
                @class([
                    'nv-hero-content-wrapper pt-4',
                    'mr-auto pr-4 ' => $orientation === 'right',
                    'ml-auto pl-4' => $orientation === 'left',
                ])
            >
                <div class="nv-hero-content-ctn max-w-lg">
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

                    @if (filled($heading))
                        <x-public::preview.h1
                            @class([
                                'mt-10' => filled($calloutText),
                                'mt-16' => blank($calloutText),
                            ])
                        >
                            {{ $heading }}
                        </x-public::preview.h1>
                    @endif

                    @if (filled($description))
                        <x-public::preview.lead
                            @class([
                                'mt-6' => filled($heading),
                                'mt-10' => filled($calloutText) && blank($heading),
                                'mt-16' => blank($calloutText) && blank($heading),
                            ])
                        >
                            {{ $description }}
                        </x-public::preview.lead>
                    @endif

                    @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                        <div class="nv-hero-buttons-ctn mt-10 flex flex-row items-center gap-6">
                            @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                                <x-public::preview.button
                                    :href="$primaryButtonUrl"
                                    :bg-color="$primaryButtonBgColor"
                                    :text-color="$primaryButtonTextColor ?? null"
                                    primary
                                >
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
            </div>

            <div
                @class([
                    'nv-hero-image-wrapper flex items-end',
                    'order-last' => $orientation === 'right',
                    'order-first justify-end' => $orientation === 'left',
                ])
            >
                <div class="nv-hero-image-ctn mt-0 flex justify-start gap-8">
                    <div
                        @class([
                            'order-last w-44 flex-none space-y-8 pt-80',
                            'order-none' => $orientation === 'right',
                            'mr-0' => $orientation === 'left',
                        ])
                    >
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[0]['image']) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    </div>
                    <div class="w-44 flex-none space-y-8 pt-36">
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[1]['image']) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[2]['image']) }}"
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
                            'w-44 flex-none space-y-8',
                            'order-first' => $orientation === 'left',
                        ])
                    >
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[3]['image']) }}"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="{{ asset('media/'.$images[4]['image']) }}"
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
    </div>
</div>
