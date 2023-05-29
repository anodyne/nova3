@props([
    'value' => false,
])

<x-input.field x-data="{ value: '{{ $value }}' }">
    <x-slot:leadingAddOn>
        <x-button.text tag="button" color="gray" @click.prevent="value--">
            <x-icon name="remove" size="md"></x-icon>
        </x-button.text>
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
        <x-button.text tag="button" color="gray" @click.prevent="value++">
            <x-icon name="add" size="md"></x-icon>
        </x-button.text>
    </x-slot:trailingAddOn>
</x-input.field>
