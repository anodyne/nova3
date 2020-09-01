<span class="inline-flex rounded-md shadow-sm">
    <button {{ $attributes->merge(['type' => 'button', 'class' => "{$baseStyles()} {$colorStyles()} {$sizeStyles()}"]) }}>
        {{ $slot }}
    </button>
</span>