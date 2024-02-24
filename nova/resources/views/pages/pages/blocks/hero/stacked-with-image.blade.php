<div
    @class([
        'nv-hero nv-hero-stacked-with-image relative isolate overflow-hidden py-24 font-[family-name:--font-body] sm:py-32',
        'nv-hero-stacked-with-image-light bg-[--bg-light]' => ! $dark,
        'nv-hero-stacked-with-image-dark bg-[--bg-dark]' => $dark,
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

    <div class="nv-hero-wrapper relative z-10 mx-auto flex max-w-7xl flex-col px-6 lg:px-8">
        <div class="nv-hero-ctn mx-auto max-w-2xl text-center">
            @if (filled($calloutText))
                <div
                    @class([
                        'nv-hero-callout-ctn',
                        'mt-24 sm:mt-32 lg:mt-16' => isset($orientation) && $orientation === 'bottom',
                    ])
                >
                    <a href="{{ $calloutUrl ?? '#' }}" class="nv-hero-callout inline-flex space-x-6 transition">
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
                        'mt-24 sm:mt-32 lg:mt-16' => blank($calloutText) && isset($orientation) && $orientation === 'bottom',
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
                <div class="nv-hero-buttons-ctn mt-10 flex flex-col items-center justify-center gap-6 lg:flex-row">
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

        @if ($mediaType !== 'none')
            <div
                @class([
                    'nv-hero-image-ctn flow-root',
                    'order-none mt-16 sm:mt-24' => isset($orientation) && $orientation === 'bottom',
                    'order-first mb-16 sm:mb-24' => isset($orientation) && $orientation === 'top',
                ])
            >
                @if (isset($image) && filled($image))
                    <img
                        src="{{ asset('media/'.$image) }}"
                        alt=""
                        width="2432"
                        height="1442"
                        @class([
                            'nv-hero-image rounded-3xl shadow-2xl ring-1',
                            'ring-gray-900/10' => ! $dark,
                            'bg-white/5 ring-white/10' => $dark,
                        ])
                    />
                @endif

                @if (isset($video) && filled($video))
                    <x-embed :url="$video"></x-embed>
                @endif
            </div>
        @endif
    </div>
</div>
