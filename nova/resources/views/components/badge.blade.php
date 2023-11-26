<span {{ $attributes->merge(['class' => $styles()]) }}>
    @isset($leading)
        <div class="{{ $iconColorStyles() }} mr-1 flex shrink-0 items-center">
            {{ $leading }}
        </div>
    @endisset

    <span>{{ $slot }}</span>

    @isset($trailing)
        <div class="{{ $iconStyles() }} ml-1 shrink-0">
            {{ $trailing }}
        </div>
    @endisset
</span>
