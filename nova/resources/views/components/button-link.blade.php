<span class="{{ $containerStyles() }}">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseStyles()} {$colorStyles()} {$sizeStyles()}"]) }}>
        {{ $slot }}
    </a>
</span>