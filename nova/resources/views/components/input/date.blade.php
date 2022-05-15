@props([
    'format' => 'YYYY-MM-DD',
    'icon' => 'calendar',
    'value' => '',
])

<x-input.field>
    @isset($icon)
        <x-slot:leadingAddOn>@icon($icon)</x-slot:leadingAddOn>
    @endisset

    <x-buk-pikaday format="YYYY-MM-DD" {{ $attributes->merge(['class' => 'flex-1 appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100 w-full md:w-1/2']) }} autocomplete="off" />
</x-input.field>
