@php
    $headingSize = $attributes->get('size');

    $headingWeightClasses = match ($headingSize) {
        'xl' => 'font-bold!',
        'lg' => 'font-semibold!',
        default => 'font-medium',
    };
@endphp

<flux:heading {{ $attributes->class([$headingWeightClasses]) }}>
    {{ $slot }}
</flux:heading>
