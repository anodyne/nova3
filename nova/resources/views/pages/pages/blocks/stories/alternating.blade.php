<div class="@container nv-stories-alternating">
    <div
        class="@sm:py-32 @xs:py-24 relative isolate overflow-hidden font-[family-name:--font-body]"
        @isset($backgroundColor)
            style="background-color:{{ $backgroundColor }}"
        @endisset
    >
        @if ($backgroundType !== 'color' && $backgroundType !== 'transparent')
            <div class="nv-stories-overlay-ctn absolute inset-0">
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

        <div class="@lg:px-8 @xs:px-6 relative z-10 mx-auto max-w-7xl">
            <div
                @class([
                    'flex',
                    'content-end justify-end' => $orientation === 'right',
                ])
            >
                <div
                    @class([
                        'max-w-2xl',
                        'mx-auto @lg:text-center' => $orientation === 'center',
                        '@lg:text-right' => $orientation === 'right',
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

            <livewire:pages-alternating-stories
                :dark="$dark"
                :type="$type"
                :show-description="$showDescription"
                :show-stats="$showStats"
                :selected-stories="$selectedStories"
            />
        </div>
    </div>
</div>
