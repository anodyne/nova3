<div
    @class([
        'nv-hero nv-hero-split-with-image-tiles relative isolate overflow-hidden py-24 font-[family-name:--font-body] sm:py-32',
        'nv-hero-split-with-image-tiles-light bg-[--bg-light]' => ! $dark,
        'nv-hero-split-with-image-tiles-dark bg-[--bg-dark]' => $dark,
    ])
>
    @if ($backgroundType !== 'color')
        <div class="nv-hero-overlay-ctn absolute inset-0">
            <img
                src="{{
                    match ($backgroundType) {
                        'aurora' => asset('dist/pages/aurora.jpg'),
                        'nebula' => asset('dist/pages/nebula.png'),
                        'nebula-blue' => asset('dist/pages/nebula-blue.png'),
                        'nebula-purple' => asset('dist/pages/nebula-purple.png'),
                        'peak' => asset('dist/pages/peak.webp'),
                        'pixels' => asset('dist/pages/pixels.webp'),
                        'ribbon' => asset('dist/pages/ribbon.webp'),
                        'ribbon-full' => asset('dist/pages/ribbon-full.webp'),
                        'stars' => asset('dist/pages/stars.jpg'),
                        'warp' => asset('dist/pages/warp.jpg'),
                        'warp-horizon' => asset('dist/pages/warp-horizon.png'),
                        'warp-illustrated' => asset('dist/pages/warp-illustrated.png'),
                        'warp-intense' => asset('dist/pages/warp-intense.png'),
                        'waves' => asset('dist/pages/waves.webp'),
                        'waves-flat' => asset('dist/pages/waves-flat.webp'),
                        'waves-narrow' => asset('dist/pages/waves-narrow.webp'),
                        'waves-tall' => asset('dist/pages/waves-tall.webp'),
                        default => null,
                    }
                }}"
                class="h-full w-full object-cover"
                alt=""
            />
            <div
                @class([
                    'nv-hero-overlay absolute inset-0',
                    'bg-black' => $dark,
                    'bg-white' => ! $dark,
                    match ($backgroundImageIntensity) {
                        'intense' => 'bg-opacity-20',
                        'vivid' => 'bg-opacity-40',
                        'neutral' => 'bg-opacity-50',
                        'muted' => 'bg-opacity-60',
                        'subtle' => 'bg-opacity-80',
                        default => null
                    },
                ])
            ></div>
        </div>
    @endif

    <div class="nv-hero-wrapper relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
        <div
            class="nv-hero-ctn mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 xl:mx-0 xl:max-w-none xl:grid-cols-2"
        >
            <div
                @class([
                    'nv-hero-content-wrapper lg:pt-4',
                    'lg:mr-auto lg:pr-4 ' => $orientation === 'right',
                    'lg:ml-auto lg:pl-4' => $orientation === 'left',
                ])
            >
                <div class="nv-hero-content-ctn lg:max-w-lg">
                    @if (filled($calloutText))
                        <div class="nv-hero-callout-ctn mt-24 sm:mt-32 lg:mt-16">
                            <a
                                href="{{ $calloutUrl ?? '#' }}"
                                class="nv-hero-callout inline-flex space-x-6 transition"
                            >
                                <span
                                    @class([
                                        'rounded-full px-3 py-1 text-sm/6 font-semibold ring-1 ring-inset',
                                        'bg-primary-50 text-primary-700 ring-primary-200 hover:bg-primary-100 hover:ring-primary-300' => ! $dark,
                                        'bg-primary-950 text-primary-300 ring-primary-800 hover:bg-primary-900 hover:ring-primary-700' => $dark,
                                    ])
                                >
                                    {{ $calloutText }}
                                    <span aria-hidden="true">&rarr;</span>
                                </span>
                            </a>
                        </div>
                    @endif

                    @if (filled($heading))
                        <h1
                            @class([
                                'nv-hero-heading font-[family-name:--font-header] text-4xl font-bold tracking-tight sm:text-6xl',
                                'text-gray-900' => ! $dark,
                                'text-white' => $dark,
                                'mt-10' => filled($calloutText),
                                'mt-24 sm:mt-32 lg:mt-16' => blank($calloutText),
                            ])
                        >
                            {{ $heading }}
                        </h1>
                    @endif

                    @if (filled($description))
                        <div
                            @class([
                                'nv-hero-description space-y-6 text-lg/8',
                                'text-gray-600' => ! $dark,
                                'text-gray-300' => $dark,
                                'mt-6' => filled($heading),
                            ])
                        >
                            {!! str($description)->markdown() !!}
                        </div>
                    @endif

                    @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                        <div class="nv-hero-buttons-ctn mt-10 flex flex-col items-center gap-6 lg:flex-row">
                            @if (filled($primaryButtonLabel) && filled($primaryButtonUrl))
                                <a
                                    href="{{ $primaryButtonUrl }}"
                                    @class([
                                        'nv-btn-primary w-full rounded-lg px-3.5 py-2.5 text-center text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 lg:w-auto',
                                        'nv-btn-primary-light bg-primary-600 text-white hover:bg-primary-500 focus-visible:outline-primary-600' => ! $dark,
                                        'nv-btn-primary-dark bg-primary-500 text-white hover:bg-primary-400 focus-visible:outline-primary-400' => $dark,
                                    ])
                                >
                                    {{ $primaryButtonLabel }}
                                </a>
                            @endif

                            @if (filled($secondaryButtonUrl) && filled($secondaryButtonLabel))
                                <a
                                    href="{{ $secondaryButtonUrl }}"
                                    @class([
                                        'nv-btn-secondary text-sm/6 font-semibold',
                                        'nv-btn-secondary-light text-gray-900' => ! $dark,
                                        'nv-btn-secondary-dark text-white' => $dark,
                                    ])
                                >
                                    {{ $secondaryButtonLabel }}
                                </a>
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
                    class="nv-hero-image-ctn mt-14 flex justify-end gap-8 sm:-mt-44 sm:justify-start sm:pl-20 lg:mt-0 lg:pl-0"
                >
                    <div
                        @class([
                            'w-44 flex-none space-y-8 pt-32 sm:pt-80 lg:order-last lg:pt-36 xl:pt-80',
                            'ml-auto sm:ml-0 xl:order-none' => $orientation === 'right',
                            'mr-auto sm:mr-0' => $orientation === 'left',
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
                    <div class="mr-auto w-44 flex-none space-y-8 sm:mr-0 sm:pt-52 lg:pt-36">
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
                            'w-44 flex-none space-y-8 pt-32 sm:pt-0',
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
