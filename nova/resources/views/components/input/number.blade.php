@props([
    'value' => false,
])

<div
    data-slot="control"
    @class([
        'flex items-center gap-x-2',
        $attributes->get('class') => $attributes->has('class'),
    ])
    x-data="{
        @if ($attributes->hasStartsWith('wire:model'))
            value: @entangle($attributes->wire('model'))
            .live
        @elseif ($attributes->hasStartsWith('x-model'))
            value: {{ $attributes->first('x-model') }}
        @else
            value: @js($value)
        @endif
    }"
>
    <x-button tag="button" color="neutral" x-on:click.prevent="value--" text>
        <x-icon name="remove" size="md"></x-icon>
    </x-button>

    <x-input
        type="text"
        inputmode="numeric"
        pattern="[0-9]*"
        x-model="value"
        class="text-center"
        {{ $attributes->except('class') }}
    ></x-input>

    <x-button tag="button" color="neutral" x-on:click.prevent="value++" text>
        <x-icon name="add" size="md"></x-icon>
    </x-button>
</div>
