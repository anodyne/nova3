<div
    class="relative isolate overflow-hidden py-24 font-[family-name:--font-body] sm:py-32"
    @isset($backgroundColor)
        style="background-color:{{ $backgroundColor }}"
    @endisset
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

        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="flex flex-col">
                        <dt
                            @class([
                                'flex items-center gap-x-3 text-base/7 font-semibold',
                                'text-gray-900' => ! $dark,
                                'text-white' => $dark,
                            ])
                        >
                            @if (data_get($feature, 'icon'))
                                <x-icon :name="data_get($feature, 'icon')" size="sm" class="text-primary-500"></x-icon>
                            @endif

                            {{ data_get($feature, 'heading') }}
                        </dt>
                        <dd
                            @class([
                                'mt-4 flex flex-auto flex-col text-base/7',
                                'text-gray-600' => ! $dark,
                                'text-gray-300' => $dark,
                            ])
                        >
                            <p class="flex-auto">
                                {{ data_get($feature, 'description') }}
                            </p>
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>
