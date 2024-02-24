<div
    @class([
        '@container',
        'nv-hero nv-hero-split-with-image',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $backgroundColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :background-type="$backgroundType"
        :background-image-intensity="$backgroundImageIntensity ?? null"
    >
        <div class="nv-ctn @xs:px-6 @xl:px-8 @xs:py-24 @xl:py-32 relative z-10 mx-auto max-w-7xl">
            <div
                class="nv-hero-ctn @xs:mx-auto @xs:grid-cols-1 @xs:gap-y-16 @sm:gap-y-20 @lg:mx-0 @lg:max-w-none @xs:max-w-2xl grid gap-x-8 @4xl:grid-cols-2"
            >
                <div
                    @class([
                        'nv-hero-content-wrapper',
                        'lg:mr-auto lg:pr-4 ' => isset($orientation) && $orientation === 'right',
                        'lg:ml-auto lg:pl-4' => isset($orientation) && $orientation === 'left',
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
                                    'mt-10' => filled($calloutText) && blank($heading),
                                    'mt-24 sm:mt-32 lg:mt-16' => blank($calloutText) && blank($heading),
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
                                @class([
                                    'nv-hero-image w-[76rem] rounded-3xl shadow-2xl ring-1',
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
    </x-public::block.wrapper>
</div>
