<span {{ $attributes->merge(['class' => $styles()]) }}>
    @isset($leadingIcon)
        <div>
            {{ $leadingIcon }}
        </div>
    @endisset

    <span>{{ $slot }}</span>

    @isset($trailingIcon)
        <div>
            {{ $trailingIcon }}
        </div>
    @endisset
</span>
