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
    'group inline-flex items-center text-center justify-center space-x-1.5 rounded-md border border-transparent font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 transition',
    'px-3 py-2 text-sm sm:px-2.5 sm:py-1.5 sm:text-xs' => $size === 'xs',
    'px-4 py-3 md:py-2 text-base md:text-sm' => $size !== 'xs',
    'bg-primary-500 hover:bg-primary-600 focus:ring-primary-500' => $color === 'primary',
    'bg-danger-500 hover:bg-danger-600 focus:ring-danger-500' => $color === 'danger',
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