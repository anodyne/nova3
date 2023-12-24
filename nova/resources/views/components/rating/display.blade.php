@props([
    'rating',
    'type',
    'size' => 'md',
    'showDetails' => false,
])

<div class="flex items-center gap-x-3">
    <div
        @class([
            'flex items-center justify-center font-bold ring-1 ring-inset',
            match ($size) {
                'xs' => 'size-5 rounded text-xs',
                'sm' => 'size-6 rounded-md text-sm',
                'lg' => 'h-10 w-10 rounded-md text-xl',
                default => 'h-8 w-8 rounded-md text-lg',
            },
            match ($rating) {
                0 => 'bg-green-50 text-green-600 ring-green-500/10 dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/20',
                1 => 'bg-yellow-50 text-yellow-600 ring-yellow-500/10 dark:bg-yellow-400/10 dark:text-yellow-400 dark:ring-yellow-400/20',
                2 => 'bg-orange-50 text-orange-600 ring-orange-500/10 dark:bg-orange-400/10 dark:text-orange-400 dark:ring-orange-400/20',
                3 => 'bg-red-50 text-red-600 ring-red-500/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/20',
            },
        ])
    >
        {{ $rating }}
    </div>

    @if ($showDetails)
        <div class="text-xs">
            <p class="font-medium text-gray-600 dark:text-gray-400">{{ str($type)->ucfirst() }}</p>
            <p class="text-gray-500">
                {{ settings("ratings.{$type}.description_{$rating}") }}
            </p>
        </div>
    @endif
</div>
