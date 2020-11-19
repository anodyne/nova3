<button {{ $attributes->merge(['type' => 'button', 'class' => "{$baseStyles()} {$colorStyles()} {$sizeStyles()}"]) }}>
    {{ $slot }}
</button>