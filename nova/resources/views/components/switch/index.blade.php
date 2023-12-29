@props([
    'name' => false,
    'value' => false,
    'onValue' => true,
    'offValue' => false,
    'disabled' => false,
    'color' => 'primary',
])

@php
    $color = ($color === 'primary' && settings('appearance.panda')) ? 'panda' : $color;
@endphp

<div
    x-data="{
        @if ($attributes->hasStartsWith('wire:model'))
            value: $wire.entangle('{{ $attributes->wire('model')->value() }}').live,
        @elseif ($attributes->hasStartsWith('x-model'))
            value: {{ $attributes->first('x-model') }},
        @else
            value: {{ Illuminate\Support\Js::from($value) }},
        @endif
        onValue: {{ Illuminate\Support\Js::from($onValue) }},
        offValue: {{ Illuminate\Support\Js::from($offValue) }},
        disabled: {{ Illuminate\Support\Js::from($disabled) }},
        toggle () {
            if (this.disabled) {
                return;
            }

            if (this.value == this.onValue) {
                this.value = this.offValue;
            } else {
                this.value = this.onValue;
            }

            this.$dispatch('input', this.value);
            this.$dispatch('toggle-switch-changed', { value: this.value });
        },
        isChecked () {
            return this.value == this.onValue;
        }
    }"
    @if ($attributes->hasStartsWith('x-model'))
        x-modelable="value"
        {{ $attributes->whereStartsWith('x-model') }}
    @endif
    class="flex items-center justify-center"
>
    <input type="hidden" x-bind:value="value" @if ($name) name="{{ $name }}" @endif />

    <button
        x-ref="toggle"
        type="button"
        x-on:click="toggle"
        role="switch"
        x-bind:aria-checked="isChecked()"
        x-bind:aria-labelledby="{{ $attributes->get('id') }}"
        x-bind:data-checked="isChecked()"
        x-bind:data-disabled="disabled"
        @class([
            // Base styles
            'group relative isolate inline-flex h-6 w-10 cursor-default rounded-full p-[3px] sm:h-5 sm:w-8',

            // Transitions
            'transition duration-0 ease-in-out data-[changing]:duration-200',

            // Outline and background color in forced-colors mode so switch is still visible
            'forced-colors:outline forced-colors:[--switch-bg:Highlight] dark:forced-colors:[--switch-bg:Highlight]',

            // Unchecked
            'bg-gray-200 ring-1 ring-inset ring-black/5 dark:bg-white/5 dark:ring-white/15',

            // Checked
            'data-[checked]:bg-[--switch-bg] data-[checked]:ring-[--switch-bg-ring] dark:data-[checked]:bg-[--switch-bg] dark:data-[checked]:ring-[--switch-bg-ring]',

            // Focus
            'focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500',

            // Hover
            'hover:ring-black/15 hover:data-[checked]:ring-[--switch-bg-ring]',
            'dark:hover:ring-white/25 dark:hover:data-[checked]:ring-[--switch-bg-ring]',

            // Disabled
            'data-[disabled]:bg-gray-200 data-[disabled]:data-[checked]:bg-gray-200 data-[disabled]:opacity-50 data-[disabled]:data-[checked]:ring-black/5',
            'dark:data-[disabled]:bg-white/15 dark:data-[disabled]:data-[checked]:bg-white/15 dark:data-[disabled]:data-[checked]:ring-white/15',

            // Colors
            match ($color) {
                'danger' => '[--switch-bg-ring:theme(colors.danger.600/80%)] [--switch-bg:theme(colors.danger.500)] [--switch-ring:theme(colors.danger.600/80%)] [--switch-shadow:theme(colors.danger.900/20%)] [--switch:white] dark:[--switch-bg-ring:transparent]',
                'panda' => '[--switch:white] [--switch-bg-ring:theme(colors.gray.950/90%)] [--switch-bg:theme(colors.gray.900)] [--switch-ring:theme(colors.gray.950/90%)] [--switch-shadow:theme(colors.black/10%)] dark:[--switch-bg-ring:transparent] dark:[--switch-bg-ring:theme(colors.gray.700/90%)] dark:[--switch-bg:theme(colors.white/25%)] dark:[--switch-ring:theme(colors.gray.700/90%)]',
                default => '[--switch:white] [--switch-bg-ring:theme(colors.primary.600/80%)] [--switch-bg:theme(colors.primary.500)] [--switch-ring:theme(colors.primary.600/80%)] [--switch-shadow:theme(colors.primary.900/20%)] dark:[--switch-bg-ring:transparent]',
            },
        ])
        {{ $attributes->only('id') }}
    >
        <span
            x-bind:class="{
                'translate-x-4 sm:translate-x-3': isChecked(),
                'translate-x-0': ! isChecked(),
            }"
            class="pointer-events-none relative inline-block size-[1.125rem] translate-x-0 rounded-full border border-transparent bg-white shadow ring-1 ring-black/5 transition duration-200 ease-in-out group-data-[checked]:translate-x-4 group-data-[checked]:bg-[--switch] group-data-[disabled]:group-data-[checked]:bg-white group-data-[disabled]:group-data-[checked]:shadow group-data-[checked]:shadow-[--switch-shadow] group-data-[checked]:ring-[--switch-ring] group-data-[disabled]:group-data-[checked]:ring-black/5 sm:size-3.5 sm:group-data-[checked]:translate-x-3"
            aria-hidden="true"
        ></span>
    </button>
</div>
