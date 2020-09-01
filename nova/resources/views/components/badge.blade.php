<span {{ $attributes->merge(['class' => "{$baseStyles()} {$sizeStyles()} {$colorStyles()}"]) }}>
    {{ $slot }}
</span>
