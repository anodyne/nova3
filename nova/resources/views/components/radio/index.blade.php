@props([
    'label' => null,
])

@php
    $icon = $attributes->get('icon');

    if ($icon instanceof BackedEnum) {
        $novaIcon = $icon;
    }
@endphp

<flux:radio
    :label="$label"
    {{ $attributes->merge(['data-slot' => 'control']) }}
>
    @isset($novaIcon)
        <x-slot name="icon">
            <x-icon :name="$novaIcon" size="sm"/>
        </x-slot>
    @endisset

    {{ $slot->hasActualContent() ? $slot : $label }}
</flux:radio>