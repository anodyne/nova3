<div
    class="nv-features-alternating relative isolate overflow-hidden py-24 font-[family-name:--font-body] sm:py-32"
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
            @foreach ($features as $feature)
                <div class="flex gap-x-16">
                    <div
                        @class([
                            'max-w-xl',
                            'order-last' => $loop->even,
                        ])
                    >
                        @if (isset($feature['content']))
                            <div
                                @class([
                                    'prose prose-lg max-w-none font-[family-name:--font-body]',
                                    'prose-h1:font-[family-name:--font-header]',
                                    'prose-h2:font-[family-name:--font-header]',
                                    'prose-h3:font-[family-name:--font-header]',
                                    'prose-h4:font-[family-name:--font-header]',
                                    'prose-invert' => $dark,
                                ])
                            >
                                {!! tiptap_converter()->asHTML($feature['content'] ?? ['content' => null]) !!}
                            </div>
                        @endif
                    </div>

                    <div
                        @class([
                            'flex-1 overflow-hidden rounded-xl ring-1 ring-gray-950/5',
                            'ring-gray-950/5' => ! $dark,
                            'ring-white/5' => $dark,
                            'order-first' => $loop->even,
                        ])
                    >
                        @if (isset($feature['image']) && filled($feature['image']))
                            <img
                                src="{{ asset('media/'.$feature['image']) }}"
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
