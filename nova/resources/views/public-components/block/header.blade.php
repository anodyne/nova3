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
            <x-public::h2>
                {{ $heading }}
            </x-public::h2>
        @endif

        @if (filled($description))
            <x-public::lead
                @class([
                    'mt-6' => filled($heading),
                ])
                markdown
            >
                {{ $description }}
            </x-public::lead>
        @endif
    </div>
</div>
