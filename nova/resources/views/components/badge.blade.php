<span {{ $attributes->merge(['class' => "{$baseStyles()} {$sizeStyles()} {$colorStyles()}"]) }}>
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
