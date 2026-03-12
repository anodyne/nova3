@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'iconSize' => 'md',
    'badge' => null,
    'actions' => null,
    'size' => null,
])

@aware(['color'])

<x-spacing
    {{
    $attributes->merge(['size' => 'row'])->class([
        'flex justify-between gap-x-8',
        'items-center' => blank($description),
    ])
}}
>
    <div
        @class([
            'flex flex-1',
            match ($iconSize) {
                'xl' => 'gap-x-3',
                default => 'gap-x-2',
            },
            'items-center' => blank($description),
        ])
    >
        @if (filled($icon))
            <div
                @class([
                    'shrink-0',
                    match ($color) {
                        'danger' => 'text-danger-500',
                        'info' => 'text-info-500',
                        'primary' => 'text-primary-500',
                        'success' => 'text-success-500',
                        'warning' => 'text-warning-500',
                        default => 'text-gray-500',
                    },
                ])
            >
                <x-icon :name="$icon" :size="$iconSize" class="shrink-0" />
            </div>
        @endif

        <div class="flex flex-col gap-y-0.5">
            @if (filled($title))
                <div class="flex items-center gap-x-3">
                    <x-heading
                        size="lg"
                        @class([
                            'font-(family-name:--font-header)',
                            match ($color) {
                                'danger' => 'text-danger-700',
                                'info' => 'text-info-700',
                                'primary' => 'text-primary-700',
                                'success' => 'text-success-700',
                                'warning' => 'text-warning-700',
                                'gray' => 'text-gray-600',
                                default => 'text-gray-800',
                            },
                        ])
                    >
                        {{ $title }}
                    </x-heading>

                    @if ($badge?->isNotEmpty())
                        {{ $badge }}
                    @endif
                </div>
            @endif

            @if (filled($description))
                <div
                    @class([
                        'text-sm/6 text-pretty',
                        match ($color) {
                            'danger' => 'text-danger-600',
                            'info' => 'text-info-600',
                            'primary' => 'text-primary-600',
                            'success' => 'text-success-600',
                            'warning' => 'text-warning-600',
                            default => 'text-gray-500',
                        },
                    ])
                >
                    {{ $description }}
                </div>
            @endif
        </div>
    </div>

    @if ($actions?->isNotEmpty())
        <div class="shrink-0">
            {{ $actions }}
        </div>
    @endif
</x-spacing>
