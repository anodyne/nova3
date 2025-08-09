@props([
    'title' => null,
    'subtitle' => null,
])

<div class="flex items-center gap-3" data-slot="avatar">
    <flux:avatar {{ $attributes }}></flux:avatar>

    @if ($title || $subtitle)
        <div>
            @if ($title)
                <div
                    @class([
                        'text-sm font-semibold text-gray-950 dark:text-white',
                        is_string($title) ? '' : $title?->attributes->get('class'),
                    ])
                >
                    {{ $title }}
                </div>
            @endif

            @if ($subtitle)
                <div
                    @class([
                        'text-sm text-gray-950/50 dark:text-white/50',
                        is_string($subtitle) ? '' : $subtitle?->attributes->get('class'),
                    ])
                >
                    {{ $subtitle }}
                </div>
            @endif
        </div>
    @endif
</div>
