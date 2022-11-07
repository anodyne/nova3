<span {{ $attributes->merge(['class' => $styles()]) }}>
    @isset($leadingIcon)
        <div class="{{ $iconColorStyles() }}">
            {{ $leadingIcon }}
        </div>
    @endisset

    <span>{{ $slot }}</span>

    @isset($trailingIcon)
        <div class="{{ $iconColorStyles() }}">
            {{ $trailingIcon }}
        </div>
    @endisset
</span>