<div
    @class([
        'nv-stats nv-stats-simple relative py-6 sm:py-8',
        'nv-stats-simple-light bg-[--bg-light]' => ! $dark,
        'nv-stats-simple-dark bg-[--bg-dark]' => $dark,
    ])
    @isset($backgroundColor)
        style="background-color:{{ $backgroundColor }}"
    @endisset
>
    @if ($backgroundType !== 'color')
        <div class="nv-stats-overlay-ctn absolute inset-0">
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
                    'nv-stats-overlay absolute inset-0',
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

    <div class="nv-stats-wrapper relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
        @if (filled($heading) || filled($description))
            <div class="nv-stats-content-wrapper mx-auto max-w-2xl">
                <div class="nv-stats-ctn text-center">
                    @if (filled($heading))
                        <h2
                            @class([
                                'nv-stats-heading font-[family-name:--font-header] text-3xl font-bold tracking-tight sm:text-4xl',
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
                                'nv-stats-description space-y-6 text-lg/8',
                                'text-gray-600' => ! $dark,
                                'text-gray-400' => $dark,
                                'mt-4' => filled($heading),
                            ])
                        >
                            {!! str($description)->markdown() !!}
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <dl
            @class([
                'grid grid-cols-1 gap-x-8 gap-y-16 text-center',
                'lg:grid-cols-2' => count($stats) === 2,
                'lg:grid-cols-3' => count($stats) === 3,
                'lg:grid-cols-4' => count($stats) === 4,
                'mt-16' => filled($heading) || filled($description),
            ])
        >
            @foreach ($stats as $stat)
                <livewire:pages-stat-widget
                    :identifier="$stat['stat']"
                    :heading="$stat['heading']"
                    :dark="$dark"
                    wire:key="{{ $stat['stat'] }}"
                />
            @endforeach
        </dl>
    </div>
</div>
