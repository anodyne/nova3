@php
    $icon = $attributes->get('icon');

    if ($icon && $icon instanceof BackedEnum) {
        $novaIcon = $icon;
    }
@endphp

<flux:radio {{ $attributes->merge(['data-slot' => 'control']) }}>
    @isset($novaIcon)
        <x-slot name="icon">
            <x-icon :name="$novaIcon" size="sm"/>
        </x-slot>
    @endisset

    {{ $slot }}
</flux:radio>
