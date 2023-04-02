@props([
    'tag' => 'a',
    'type' => 'button',
    'size' => 'md',
    'color' => 'primary',
    'leading' => false,
    'trailing' => false,
])

<{{ $tag }} {{ $attributes->merge([
    'type' => ($tag === 'button') ? $type : null,
])->class([
    'group inline-flex items-center text-center justify-center space-x-1.5 font-medium underline transition text-sm',
    'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400' => $color === 'primary',
    'text-danger-500 hover:text-danger-600 dark:hover:text-danger-400' => $color === 'danger',
    'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' => $color === 'gray',
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