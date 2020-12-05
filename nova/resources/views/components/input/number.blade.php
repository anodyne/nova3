@props([
    'value' => false,
])

<x-input.field x-data="{ value: '{{ $value }}' }">
    <x-slot name="leadingAddOn">
        <button type="button" class="focus:outline-none" x-on:click.prevent="value--">
            @icon('remove-alt', 'h-6 w-6')
        </button>
    </x-slot>

    <input
        x-model="value"
        type="text"
        inputmode="numeric"
        pattern="[0-9]*"
        class="appearance-none bg-transparent text-gray-700 w-full text-center border-none p-0 focus:ring-0 focus:outline-none"
        {{ $attributes->merge(['step' => 1]) }}
    >

    <x-slot name="trailingAddOn">
        <button type="button" class="focus:outline-none" x-on:click.prevent="value++">
            @icon('add-alt', 'h-6 w-6')
        </button>
    </x-slot>
</x-input.field>
