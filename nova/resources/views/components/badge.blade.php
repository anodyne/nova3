<span {{ $attributes->merge(['class' => $styles()]) }}>
    @isset($leading)
        <div class="{{ $iconStyles() }} mr-1 shrink-0">
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
