@props([
    'status',
    'size' => 'md',
])

<span
    aria-label="{{ $status->displayName() }}"
    @class([
        'h-1 w-1' => $size === 'xs',
        'h-1.5 w-1.5' => $size === 'sm',
        'h-2 w-2' => $size === 'md',
        "{$status->bgColor()} shrink-0 inline-block rounded-full",
    ])
></span>
