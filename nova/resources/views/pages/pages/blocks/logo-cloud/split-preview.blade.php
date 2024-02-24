<div
    class="py-6 sm:py-8"
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

    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-x-8 gap-y-16 lg:grid-cols-2">
            <div class="mx-auto w-full max-w-xl lg:mx-0">
                @if (filled($heading))
                    <h2
                        @class([
                            'font-[family-name:--font-header] text-3xl font-bold tracking-tight',
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
                            'nv-logos-description space-y-6 text-lg/8',
                            'text-gray-600' => ! $dark,
                            'text-gray-300' => $dark,
                            'mt-6' => filled($heading),
                        ])
                    >
                        {!! str($description)->markdown() !!}
                    </div>
                @endif
            </div>

            <div
                class="mx-auto grid w-full max-w-xl grid-cols-2 items-center gap-y-12 sm:gap-y-14 lg:mx-0 lg:max-w-none lg:pl-8"
            >
                @foreach ($logos as $logo)
                    <a href="{{ $logo['url'] ?? '#' }}" target="_blank" rel="nofollow">
                        <img
                            class="max-h-12 w-full object-contain object-left"
                            src="{{ asset('media/'.$logo['image']) }}"
                            alt=""
                            width="105"
                            height="48"
                        />
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
