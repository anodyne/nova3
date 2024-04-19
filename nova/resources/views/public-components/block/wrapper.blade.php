@props([
    'noBackground' => false,
    'bgOption' => null,
    'bgImageIntensity' => null,
    'spacingHorizontal' => null,
    'spacingVertical' => null,
    'afterContainer' => null,
    'beforeContainer' => null,
])

@php
    $bgOption = filled($bgOption) && in_array($bgOption, ['color', 'transparent', 'tailwind']) ? null : $bgOption;
    $hasBackgroundImage = filled($bgOption);
@endphp

<div
    @class([
        'nv-wrapper relative isolate overflow-hidden font-[family-name:--font-body]',
        'bg-[--bgColor]' => ! $noBackground,
        $attributes->get('class') => $attributes->has('class'),
    ])
>
    @if ($hasBackgroundImage)
        <div class="nv-overlay-ctn absolute inset-0">
            <img
                src="{{ match ($bgOption) {
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
                    } }}"
                class="h-full w-full object-cover"
                alt=""
            />
            <div
                @class([
                    'nv-overlay absolute inset-0 bg-white dark:bg-black',
                    match ($bgImageIntensity) {
                        'intense' => 'bg-opacity-20 dark:bg-opacity-20',
                        'vivid' => 'bg-opacity-40 dark:bg-opacity-40',
                        'neutral' => 'bg-opacity-50 dark:bg-opacity-50',
                        'muted' => 'bg-opacity-60 dark:bg-opacity-60',
                        'subtle' => 'bg-opacity-80 dark:bg-opacity-80',
                        default => null
                    },
                ])
            ></div>
        </div>
    @endif

    @if (! $beforeContainer?->isEmpty())
        {{ $beforeContainer }}
    @endif

    <div
        @class([
            'nv-ctn relative z-10 mx-auto max-w-7xl',
            match ($spacingHorizontal) {
                'small' => 'px-4',
                'large' => 'px-16',
                'extra-large' => 'px-32',
                'none' => 'px-0',
                default => 'px-8',
            } => isset($spacingHorizontal),
            match ($spacingVertical) {
                'small' => 'py-8',
                'large' => 'py-32',
                'extra-large' => 'py-64',
                'none' => 'py-0',
                default => 'py-16',
            } => isset($spacingVertical),
        ])
    >
        {{ $slot }}
    </div>

    @if (! $afterContainer?->isEmpty())
        {{ $afterContainer }}
    @endif
</div>
