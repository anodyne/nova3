@props([
    'icon' => null,
    'iconTrailing' => null,
])

@php
    $iconLeading ??= $icon;
@endphp

<flux:input {{ $attributes }}>
    @isset($iconLeading)
        <x-slot name="iconLeading">
            {{ $iconLeading }}
        </x-slot>
    @endisset

    @isset($iconTrailing)
        <x-slot name="iconTrailing">
            {{ $iconTrailing }}
        </x-slot>
    @endisset
</flux:input>
