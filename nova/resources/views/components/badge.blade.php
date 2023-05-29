<span {{ $attributes->merge(['class' => $styles()]) }}>
    @isset($leadingIcon)
        <div class="{{ $iconStyles() }} shrink-0 mr-1">
            {{ $leadingIcon }}
        </div>
    @endisset

    <span>{{ $slot }}</span>

    @isset($trailingIcon)
        <div class="{{ $iconStyles() }} shrink-0 ml-1">
            {{ $trailingIcon }}
        </div>
    @endisset
</span>