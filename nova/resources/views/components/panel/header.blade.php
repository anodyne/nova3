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
    @class([
        'flex justify-between gap-x-8',
        'items-center' => blank($description),
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes->merge(['size' => 'row']) }}
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
                        'danger' => 'text-danger-500 dark:text-danger-400',
                        'info' => 'text-info-500 dark:text-info-400',
                        'primary' => 'text-primary-500 dark:text-primary-400',
                        'success' => 'text-success-500 dark:text-success-400',
                        'warning' => 'text-warning-500 dark:text-warning-400',
                        default => 'text-gray-500 dark:text-gray-400',
                    },
                ])
            >
                <x-icon :name="$icon" :size="$iconSize"></x-icon>
            </div>
        @endif

        <div class="flex flex-col gap-y-0.5">
            @if (filled($title))
                <div class="flex items-center gap-x-3">
                    <h3
                        @class([
                            'font-[family-name:--font-header]',
                            match ($size) {
                                'sm' => 'text-sm/6 font-semibold',
                                default => 'text-base/6 font-semibold',
                            },
                            match ($color) {
                                'danger' => 'text-danger-700 dark:text-danger-300',
                                'info' => 'text-info-700 dark:text-info-300',
                                'primary' => 'text-primary-700 dark:text-primary-300',
                                'success' => 'text-success-700 dark:text-success-300',
                                'warning' => 'text-warning-700 dark:text-warning-300',
                                'gray' => 'text-gray-600 dark:text-gray-400',
                                default => 'text-gray-950 dark:text-white',
                            },
                        ])
                    >
                        {{ $title }}
                    </h3>

                    @if ($badge?->isNotEmpty())
                        {{ $badge }}
                    @endif
                </div>
            @endif

            @if (filled($description))
                <div
                    @class([
                        'text-pretty text-sm/6',
                        match ($color) {
                            'danger' => 'text-danger-600 dark:text-danger-400',
                            'info' => 'text-info-600 dark:text-info-400',
                            'primary' => 'text-primary-600 dark:text-primary-400',
                            'success' => 'text-success-600 dark:text-success-400',
                            'warning' => 'text-warning-600 dark:text-warning-400',
                            default => 'text-gray-500 dark:text-gray-400',
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
