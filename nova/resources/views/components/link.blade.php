<a href="{{ $href }}" {{ $attributes->merge(['class' => $styles()]) }}>
    @if ($leading)
        @icon($leading, 'h-6 w-6 md:h-5 md:w-5')
    @endif

    <span>{{ $slot }}</span>

    @if ($trailing)
        @icon($trailing, 'h-6 w-6 md:h-5 md:w-5')
    @endif
</a>