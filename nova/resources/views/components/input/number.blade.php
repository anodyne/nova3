@props([
    'value' => false,
])

<x-input.field x-data="{ value: '{{ $value }}' }">
    <x-slot:leadingAddOn>
        <button type="button" class="focus:outline-none" @click.prevent="value--">
            @icon('remove', 'h-6 w-6')
        </button>
    </x-slot:leadingAddOn>

    <input
        x-model="value"
        type="text"
        inputmode="numeric"
        pattern="[0-9]*"
        class="appearance-none bg-transparent text-gray-11 w-full text-center border-none p-0 focus:ring-0 focus:outline-none"
        {{ $attributes->merge(['step' => 1]) }}
    >

    <x-slot:trailingAddOn>
        <button type="button" class="focus:outline-none" @click.prevent="value++">
            @icon('add', 'h-6 w-6')
        </button>
    </x-slot:trailingAddOn>
</x-input.field>
