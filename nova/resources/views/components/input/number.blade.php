@props([
    'value' => false,
])

<div class="field-group" x-data="{ value: '{{ $value }}' }">
    <button type="button" class="field-addon" x-on:click.prevent="value--">
        @icon('remove-alt', 'h-6 w-6')
    </button>

    <input
        x-model="value"
        type="text"
        inputmode="numeric"
        pattern="[0-9]*"
        class="appearance-none bg-transparent text-gray-700 w-full text-center focus:outline-none"
        {{ $attributes->merge(['step' => 1]) }}
    >

    <button type="button" class="field-addon" x-on:click.prevent="value++">
        @icon('add-alt', 'h-6 w-6')
    </button>
</div>
