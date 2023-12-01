@props([
    'name',
    'value' => false,
    'onValue' => true,
    'offValue' => false,
    'activeBg' => 'bg-primary-500',
    'label' => null,
    'disabled' => false,
    'help' => false,
    'labelPosition' => 'after',
])

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

            this.$dispatch('toggle-switch-changed', { value: this.value });
        },
        isChecked () {
            return this.value == this.onValue;
        }
    }"
    class="flex items-center justify-center"
    x-id="['toggle-label']"
>
    <input type="hidden" name="{{ $name }}" :value="value" />

    @if (filled($label))
        <label
            x-on:click="
                $refs.toggle.click()
                $refs.toggle.focus()
            "
            :id="$id('toggle-label')"
            class="mr-3 text-sm font-medium text-gray-900 dark:text-white"
        >
            {{ $label }}
        </label>
    @endif

    <button
        x-ref="toggle"
        type="button"
        x-on:click="toggle"
        role="switch"
        x-bind:aria-checked="isChecked()"
        x-bind:aria-labelledby="$id('toggle-label')"
        x-bind:class="{
            '{{ $activeBg }}': isChecked(),
            'bg-gray-200': ! isChecked(),
            'opacity-75 cursor-not-allowed': disabled,
            'cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2':
                ! disabled,
        }"
        class="relative inline-flex h-6 w-11 flex-shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out"
    >
        <span
            x-bind:class="{
                'translate-x-5': isChecked(),
                'translate-x-0': ! isChecked(),
            }"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
            aria-hidden="true"
        ></span>
    </button>
</div>
