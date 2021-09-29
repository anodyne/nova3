<div {{ $attributes->merge(['class' => "{$heightStyles()} {$widthStyles()}"]) }}>
    {{ $slot }}
</div>