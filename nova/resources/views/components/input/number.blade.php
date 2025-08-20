@php
    $min = $attributes->pluck('min') ?? 0;
    $max = $attributes->pluck('max');
    $step = $attributes->pluck('step') ?? 1;
    $value = $attributes->pluck('value') ?? 0;
@endphp

<div
    x-data="{
        @if ($attributes->hasStartsWith('wire:model'))
            value: @entangle($attributes->wire('model'))
            .live,
        @elseif ($attributes->hasStartsWith('x-model'))
            value: {{ $attributes->first('x-model') }},
        @else
            value: @js($value ?? 0)
            ,
        @endif
        min: @js($min ?? 0),
        max: @js($max ?? null),
        step: @js($step ?? 1),

        increment() {
            const newValue = parseInt(this.value) + this.step;
            this.value = this.max !== null ? Math.min(newValue, this.max) : newValue;
        },

        decrement() {
            const newValue = parseInt(this.value) - this.step;
            this.value = Math.max(newValue, this.min);
        },

        validateInput() {
            this.value = Math.max(this.min, parseInt(this.value) || this.min);
            if (this.max !== null) {
                this.value = Math.min(this.value, this.max);
            }
        }
    }"
>
    <flux:field>
        @if ($attributes->has('label'))
            <x-label>{{ $attributes->pluck('label') }}</x-label>
        @endif

        @if ($attributes->has('description'))
            <flux:description>{{ $attributes->pluck('description') }}</flux:description>
        @endif

        <x-input.group>
            <x-button x-on:click.prevent="decrement()" x-bind:disabled="max !== null && value <= min" type="button">
                <x-icon :name="Tabler::Minus" size="sm"></x-icon>
            </x-button>

            <x-input
                type="number"
                inputmode="numeric"
                x-model.number="value"
                x-on:blur="validateInput()"
                x-on:keydown.arrow-up.prevent="increment()"
                x-on:keydown.arrow-down.prevent="decrement()"
                :min="$min"
                :max="$max"
                :step="$step"
                class:input="text-center [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none [-moz-appearance:textfield]"
                role="spinbutton"
                :aria-label="$attributes->get('label', 'Number input')"
                :aria-valuemin="$min"
                :aria-valuemax="$max"
                :aria-valuenow="$value"
                {{ $attributes->except(['label', 'description', 'min', 'max', 'step']) }}
            />

            <x-button x-on:click.prevent="increment()" x-bind:disabled="max !== null && value >= max" type="button">
                <x-icon :name="Tabler::Plus" size="sm"></x-icon>
            </x-button>
        </x-input.group>

        <flux:error :name="$attributes->wire('model')->value() ?? $attributes->get('name') ?? ''" />
    </flux:field>
</div>
