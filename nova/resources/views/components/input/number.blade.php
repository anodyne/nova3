@props([
    'value' => false,
])

<x-input.field x-data="{ value: '{{ $value }}' }">
    <x-slot name="leading">
        <x-button tag="button" color="neutral" x-on:click.prevent="value--" text>
            <x-icon name="remove" size="md"></x-icon>
        </x-button>
    </x-slot>

    <input
        x-model="value"
        type="text"
        inputmode="numeric"
        pattern="[0-9]*"
        class="w-full appearance-none border-none bg-transparent p-0 text-center focus:outline-none focus:ring-0"
        {{ $attributes->merge(['step' => 1]) }}
    />

    <x-slot name="trailing">
        <x-button tag="button" color="neutral" x-on:click.prevent="value++" text>
            <x-icon name="add" size="md"></x-icon>
        </x-button>
    </x-slot>
</x-input.field>
