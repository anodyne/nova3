<span class="inline-flex rounded-md shadow-sm">
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseStyles()} {$colorStyles()} {$sizeStyles()}"]) }}>
        {{ $slot }}
    </a>
</span>