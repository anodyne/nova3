<button {{ $attributes->merge(['type' => 'button', 'class' => $styles()]) }}>
    {{ $slot }}
</button>