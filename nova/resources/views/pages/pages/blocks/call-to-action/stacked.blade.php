<div
    @class([
        'nv-cta nv-cta-stacked not-prose relative isolate overflow-hidden font-[family-name:--font-body]',
        'nv-cta-stacked-light bg-[--bg-light]' => ! $dark,
        'nv-cta-stacked-dark bg-[--bg-dark]' => $dark,
    ])
    @isset($backgroundColor)
        style="background-color:{{ $backgroundColor }}"
    @endisset
>
    @if ($backgroundType !== 'color')
        <div class="nv-cta-overlay-ctn absolute inset-0">
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
                    'nv-cta-overlay absolute inset-0',
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

    <div class="nv-cta-wrapper relative z-10 px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
        <div class="nv-cta-ctn mx-auto max-w-2xl text-center">
            @if (filled($heading))
                <h2
                    @class([
                        'nv-cta-heading font-[family-name:--font-header] text-3xl font-bold tracking-tight sm:text-4xl',
                        'text-gray-900' => ! $dark,
                        'text-white' => $dark,
                    ])
                >
                    {{ $heading }}
                </h2>
            @endif

            @if (filled($primaryButtonUrl) || filled($secondaryButtonUrl))
                <div class="nv-cta-buttons-ctn mt-10 flex items-center justify-center gap-x-6">
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
</div>
