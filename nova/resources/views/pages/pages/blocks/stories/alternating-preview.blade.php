<div
    class="nv-features-alternating relative isolate overflow-hidden py-6 font-[family-name:--font-body] sm:py-8"
    @isset($backgroundColor)
        style="background-color:{{ $backgroundColor }}"
    @endisset
>
    @if ($backgroundType !== 'color')
        <div class="nv-features-overlay-ctn absolute inset-0">
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
                    'nv-features-overlay absolute inset-0',
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

    <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
        <div
            @class([
                'flex',
                'content-end justify-end' => $orientation === 'right',
            ])
        >
            <div
                @class([
                    'max-w-2xl',
                    'mx-auto lg:text-center' => $orientation === 'center',
                    'lg:text-right' => $orientation === 'right',
                ])
            >
                @if (filled($heading))
                    <h2
                        @class([
                            'nv-features-heading font-[family-name:--font-header] text-3xl font-bold tracking-tight sm:text-4xl',
                            'text-gray-900' => ! $dark,
                            'text-white' => $dark,
                        ])
                    >
                        {{ $heading }}
                    </h2>
                @endif

                @if (filled($description))
                    <div
                        @class([
                            'nv-features-description space-y-6 text-lg/8',
                            'text-gray-600' => ! $dark,
                            'text-gray-300' => $dark,
                            'mt-6' => filled($heading),
                        ])
                    >
                        {!! str($description)->markdown() !!}
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-16 space-y-24 sm:mt-20 lg:mt-24">
            <div class="flex gap-x-16">
                <div class="flex-1 font-[family-name:Flow_Circular]">
                    <h2
                        @class([
                            'nv-features-heading text-2xl font-bold tracking-tight sm:text-3xl',
                            'text-gray-900' => ! $dark,
                            'text-white' => $dark,
                        ])
                    >
                        Story title
                    </h2>

                    @if ($showDescription)
                        <p
                            @class([
                                'mt-4 text-base/7',
                                'text-gray-900' => ! $dark,
                                'text-gray-400' => $dark,
                            ])
                        >
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Id nihil in deserunt iste itaque
                            voluptates consequatur incidunt?
                        </p>
                    @endif

                    <div class="nv-cta-buttons-ctn mt-6 flex items-center">
                        <a
                            href="#"
                            @class([
                                'nv-btn-primary w-full rounded-lg px-3.5 py-2.5 text-center text-sm font-semibold !no-underline shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 lg:w-auto',
                                'nv-btn-primary-light bg-gray-800 !text-white hover:bg-gray-950' => ! $dark,
                                'nv-btn-primary-dark bg-white bg-opacity-75 !text-gray-950 backdrop-blur hover:bg-opacity-100' => $dark,
                            ])
                        >
                            Go to story
                        </a>
                    </div>

                    @if ($showStats)
                        <div class="mt-8 grid gap-y-8 lg:grid-cols-2">
                            <div
                                @class([
                                    'border-l-2 py-2 pl-6',
                                    'border-gray-950/10' => ! $dark,
                                    'border-white/10' => $dark,
                                ])
                            >
                                <h3
                                    @class([
                                        'nv-stat-heading text-base/7',
                                        'text-gray-600' => ! $dark,
                                        'text-gray-400' => $dark,
                                    ])
                                >
                                    Total posts
                                </h3>

                                <div
                                    @class([
                                        'nv-stat-value order-first text-3xl font-semibold tracking-tight sm:text-5xl',
                                        'text-gray-900' => ! $dark,
                                        'text-white' => $dark,
                                    ])
                                >
                                    1
                                </div>
                            </div>
                            <div
                                @class([
                                    'border-l-2 py-2 pl-6',
                                    'border-gray-950/10' => ! $dark,
                                    'border-white/10' => $dark,
                                ])
                            >
                                <h3
                                    @class([
                                        'nv-stat-heading text-base/7',
                                        'text-gray-600' => ! $dark,
                                        'text-gray-400' => $dark,
                                    ])
                                >
                                    Total words
                                </h3>

                                <div
                                    @class([
                                        'nv-stat-value order-first text-3xl font-semibold tracking-tight sm:text-5xl',
                                        'text-gray-900' => ! $dark,
                                        'text-white' => $dark,
                                    ])
                                >
                                    111
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    <img
                        src="https://picsum.photos/id/56/2400/1400/"
                        alt=""
                        width="2432"
                        height="1442"
                        @class([
                            'nv-hero-image w-[76rem] rounded-3xl shadow-2xl ring-1',
                            'ring-gray-900/10' => ! $dark,
                            'ring-white/10' => $dark,
                        ])
                    />
                </div>
            </div>
        </div>
    </div>
</div>
