@props([
    'content',
    'date' => null,
    'icon' => null,
    'variant' => null,
])

<div class="relative">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div
            @class([
                'w-full border-t',
                match ($variant) {
                    'danger' => 'border-danger-200 dark:border-danger-900',
                    default => 'border-gray-200 dark:border-gray-700',
                },
            ])
        ></div>
    </div>
    <div class="relative flex justify-between">
        <span
            @class([
                'flex items-center gap-x-1 bg-white pr-4 text-sm font-medium dark:bg-gray-900',
                match ($variant) {
                    'danger' => 'text-danger-500',
                    default => 'text-gray-500',
                },
            ])
        >
            @if (filled($icon))
                <x-icon :name="$icon" size="sm"></x-icon>
            @endif

            {{ $content }}
        </span>

        @if (filled($date))
            <span
                @class([
                    'flex items-center gap-x-1 bg-white pl-4 text-xs font-medium dark:bg-gray-900',
                    match ($variant) {
                        'danger' => 'text-danger-400 dark:text-danger-800',
                        default => 'text-gray-500',
                    },
                ])
            >
                {{ format_date($date) }}
            </span>
        @endif
    </div>
</div>
