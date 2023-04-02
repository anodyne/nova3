@props([
    'value' => false,
])

<x-input.field x-data="{ value: '{{ $value }}' }">
    <x-slot:leadingAddOn>
        <x-link tag="button" color="gray" @click.prevent="value--">
            @icon('remove', 'h-6 w-6')
        </x-link>
    </x-slot:leadingAddOn>

    <input
        x-model="value"
        type="text"
        inputmode="numeric"
        pattern="[0-9]*"
        class="appearance-none bg-transparent w-full text-center border-none p-0 focus:ring-0 focus:outline-none"
        {{ $attributes->merge(['step' => 1]) }}
    >

    <x-slot:trailingAddOn>
        <x-link tag="button" color="gray" @click.prevent="value++">
            @icon('add', 'h-6 w-6')
        </x-link>
    </x-slot:trailingAddOn>
</x-input.field>
