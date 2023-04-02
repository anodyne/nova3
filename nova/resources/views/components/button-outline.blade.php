@props([
    'tag' => 'button',
    'type' => 'button',
    'color' => 'primary',
    'leading' => false,
    'trailing' => false,
    'size' => null,
])

<{{ $tag }} {{ $attributes->merge([
    'type' => ($tag === 'button') ? $type : null,
])->class([
    'group inline-flex items-center text-center justify-center space-x-1.5 rounded-md border bg-transparent font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition',
    'px-3 py-2 text-sm sm:px-2.5 sm:py-1.5 sm:text-xs' => $size === 'xs',
    'px-4 py-3 md:py-2 text-base md:text-sm' => $size !== 'xs',
    'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 border-primary-300 dark:border-primary-700 hover:border-primary-400 dark:hover:border-primary-600 focus:ring-primary-200 dark:focus:ring-primary-800' => $color === 'primary',
    'text-danger-500 hover:text-danger-600 dark:hover:text-danger-400 border-danger-300 dark:border-danger-700 hover:border-danger-400 dark:hover:border-danger-600 focus:ring-danger-200 dark:focus:ring-danger-800' => $color === 'danger',
]) }}>
    @if ($leading)
        <span class="shrink-0">
            @icon($leading, 'h-5 w-5')
        </span>
    @endif

    <span>{{ $slot }}</span>

    @if ($trailing)
        <span class="shrink-0">
            @icon($trailing)
        </span>
    @endif
</{{ $tag }}>