@props([
    'orientation' => 'left',
    'heading' => null,
    'description' => null,
])

<div @class([
    'nv-header-wrapper flex',
    'content-end justify-end' => $orientation === 'right',
])>
    <div
        @class([
            'nv-header-ctn max-w-2xl',
            'mx-auto @lg:text-center' => $orientation === 'center',
            '@lg:text-right' => $orientation === 'right',
        ])
    >
        @if (filled($heading))
            <h2
                class="nv-header-heading font-[family-name:--font-header] text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl"
            >
                {{ $heading }}
            </h2>
        @endif

        @if (filled($description))
            <div
                @class([
                    'nv-header-description space-y-6 text-lg/8 text-gray-600 dark:text-gray-400',
                    'mt-6' => filled($heading),
                ])
            >
                {!! str($description)->markdown() !!}
            </div>
        @endif
    </div>
</div>
