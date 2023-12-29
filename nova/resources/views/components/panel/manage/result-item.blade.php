@props([
    'value',
    'text',
])

<x-dropdown.item
    type="button"
    class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-700 transition hover:bg-gray-950/[.03] focus:outline-none md:text-sm dark:text-gray-300 dark:hover:bg-white/5"
    wire:click="add({{ $value }})"
>
    {{ $text }}
</x-dropdown.item>
