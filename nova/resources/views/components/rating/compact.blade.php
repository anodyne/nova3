@props([
    'label',
    'value',
])

@use('Nova\Stories\Enums\ContentRatingValue')

<div
    @class([
        'flex items-baseline gap-x-1 rounded-lg border border-black/10 px-1.5 py-0.5 shadow-[inset_0px_1px_theme(colors.white/.3),0_1px_2px_0_rgb(0_0_0_/_0.05)] dark:border-white/20 dark:shadow-none',
        match ($value) {
            ContentRatingValue::Level0 => 'bg-green-500',
            ContentRatingValue::Level1 => 'bg-yellow-400',
            ContentRatingValue::Level2 => 'bg-orange-500',
            ContentRatingValue::Level3 => 'bg-red-500',
            default => 'text-gray-500',
        },
    ])
>
    <span
        @class([
            'text-sm font-semibold',
            match ($value) {
                ContentRatingValue::Level0 => 'text-green-800',
                ContentRatingValue::Level1 => 'text-yellow-700',
                ContentRatingValue::Level2 => 'text-orange-900',
                ContentRatingValue::Level3 => 'text-red-950',
                default => 'text-gray-800',
            },
        ])
    >
        {{ $label }}
    </span>
    <span
        @class([
            'text-xl font-bold tabular-nums',
            match ($value) {
                ContentRatingValue::Level1 => 'text-yellow-800',
                default => 'text-white'
            },
        ])
    >
        {{ $value }}
    </span>
</div>
