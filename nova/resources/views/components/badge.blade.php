<span {{ $attributes->merge(['class' => $styles()]) }}>
    @isset($leadingIcon)
        <div class="{{ $iconStyles() }}">
            {{ $leadingIcon }}
        </div>
    @endisset

    <span>{{ $slot }}</span>

    @isset($trailingIcon)
        <div class="{{ $iconStyles() }}">
            {{ $trailingIcon }}
        </div>
    @endisset
</span>