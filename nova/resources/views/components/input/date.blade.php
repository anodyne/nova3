@props([
    'format' => 'YYYY-MM-DD',
    'icon' => 'calendar',
    'value' => '',
])

<x-input.field>
    @isset($icon)
        <x-slot name="leadingAddOn">@icon($icon)</x-slot>
    @endisset

    <x-buk-pikaday format="YYYY-MM-DD" {{ $attributes->merge(['class' => 'form-field w-full | md:w-1/2']) }} autocomplete="off" />
</x-input.field>
