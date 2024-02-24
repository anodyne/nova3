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
        @if (filled($heading))
            <h2
                @class([
                    'text-center font-[family-name:--font-header] text-lg/8 font-semibold',
                    'text-gray-900' => ! $dark,
                    'text-white' => $dark,
                ])
            >
                {{ $heading }}
            </h2>
        @endif

        <div
            @class([
                'mx-auto grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:gap-x-10 lg:mx-0 lg:max-w-none',
                'mt-10' => filled($heading),
            ])
        >
            @foreach ($logos as $logo)
                <a href="{{ $logo['url'] ?? '#' }}" target="_blank" rel="nofollow">
                    <img
                        class="col-span-2 max-h-12 w-full object-contain lg:col-span-1"
                        src="{{ asset('media/'.$logo['image']) }}"
                        alt=""
                        width="158"
                        height="48"
                    />
                </a>
            @endforeach
        </div>
    </div>
</div>
