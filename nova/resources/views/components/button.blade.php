<button {{ $attributes->merge(['type' => 'button', 'class' => "{$colorStyles()} {$sizeStyles()} {$baseStyles()}"]) }}>
    {{ $slot }}
</button>