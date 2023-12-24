@props([
    'field',
    'value' => false,
    'activeValue' => true,
    'inactiveValue' => false,
    'activeBg' => 'bg-primary-500',
    'activeBorder' => 'border-primary-500',
    'inactiveBg' => 'bg-gray-400 dark:bg-gray-600',
    'inactiveBorder' => 'border-gray-400 dark:border-gray-600',
    'disabled' => false,
    'help' => false,
    'labelPosition' => 'after',
])

<div
    x-data="toggleSwitch(@js($value), @js($disabled), @js($activeValue), @js($inactiveValue))"
    @class([
        'cursor-not-allowed' => $disabled,
        'cursor-pointer' => ! $disabled,
    ])
    x-id="['toggle-label']"
    x-cloak
>
    <input type="hidden" name="{{ $field }}" :value="value" />

    <div
        @class([
            'flex space-x-4',
            'flex-row' => $labelPosition !== 'after',
            'flex-row-reverse justify-end space-x-reverse' => $labelPosition === 'after',
        ])
    >
        <label
            x-on:click="toggle()"
            :id="$id('toggle-label')"
            class="flex flex-col font-medium text-gray-600 dark:text-gray-300"
        >
            {{ $slot }}

            @if ($help)
                <span class="text-sm font-normal">
                    {{ $help }}
                </span>
            @endif
        </label>

        <button
            x-ref="toggle"
            x-on:click="toggle()"
            type="button"
            role="switch"
            :aria-checked="value"
            :aria-labelledby="$id('toggle-label')"
            :class="{ '{{ $inactiveBg }}': value === inactiveValue, '{{ $activeBg }}': value === activeValue, 'opacity-50 cursor-not-allowed': disabled, 'cursor-pointer': !disabled }"
            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800"
        >
            <span
                :class="{ 'translate-x-5 {{ $activeBorder }}': value === activeValue, 'translate-x-1 {{ $inactiveBorder }}': value === inactiveValue }"
                class="inline-block size-4 translate-x-1 translate-y-0.5 rounded-full border bg-white ring-0 transition"
                aria-hidden="true"
            ></span>
        </button>
    </div>
</div>
