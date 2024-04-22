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
            'mx-auto text-center' => $orientation === 'center',
            'text-right' => $orientation === 'right',
        ])
    >
        @if (filled($heading))
            <x-public::preview.h2>
                {{ $heading }}
            </x-public::preview.h2>
        @endif

        @if (filled($description))
            <x-public::preview.lead @class([
                'mt-6' => filled($heading),
            ])>
                {{ $description }}
            </x-public::preview.lead>
        @endif
    </div>
</div>
