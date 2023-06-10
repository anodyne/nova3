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
        'cursor-pointer' => !$disabled,
    ])
    x-id="['toggle-label']"
    x-cloak
>
    <input type="hidden" name="{{ $field }}" :value="value">

    <div
        @class([
            'flex space-x-4',
            'flex-row' => $labelPosition !== 'after',
            'flex-row-reverse space-x-reverse justify-end' => $labelPosition === 'after',
        ])
    >
        <label
            @click="toggle()"
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
            @click="toggle()"
            type="button"
            role="switch"
            :aria-checked="value"
            :aria-labelledby="$id('toggle-label')"
            :class="{ '{{ $inactiveBg }}': value === inactiveValue, '{{ $activeBg }}': value === activeValue, 'opacity-50 cursor-not-allowed': disabled, 'cursor-pointer': !disabled }"
            class="relative inline-flex shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-primary-400"
        >
            <span
                :class="{ 'translate-x-5 {{ $activeBorder }}': value === activeValue, 'translate-x-1 {{ $inactiveBorder }}': value === inactiveValue }"
                class="bg-white translate-x-1 translate-y-0.5 inline-block h-4 w-4 rounded-full ring-0 transition border"
                aria-hidden="true"
            ></span>
        </button>
    </div>
</div>