@props([
    'field',
    'value' => false,
    'activeValue' => true,
    'inactiveValue' => false,
    'activeBg' => 'bg-primary-500',
    'disabled' => false,
    'help' => false,
    'labelPosition' => 'after',
])

<div x-data="toggleSwitch(@js($value), @js($disabled), @js($activeValue), @js($inactiveValue))" @class([
    'cursor-not-allowed' => $disabled,
    'cursor-pointer' => ! $disabled,
]) x-id="['toggle-label']" x-cloak>
    <input type="hidden" name="{{ $field }}" :value="value" />

    <div @class([
        'flex space-x-4',
        'flex-row' => $labelPosition !== 'after',
        'flex-row-reverse justify-end space-x-reverse' => $labelPosition === 'after',
    ])>
        @if (! $slot->isEmpty())
            <label @click="toggle()" :id="$id('toggle-label')" class="flex flex-col font-medium text-gray-700 dark:text-gray-300">
                {{ $slot }}

                @if ($help)
                    <span class="text-sm font-normal">
                        {{ $help }}
                    </span>
                @endif
            </label>
        @endif

        <button
            x-ref="toggle"
            @click="toggle()"
            type="button"
            role="switch"
            :aria-checked="value"
            :aria-labelledby="$id('toggle-label')"
            :class="{
                'bg-gray-200 dark:bg-white/10': value === inactiveValue,
                '{{ $activeBg }}': value === activeValue,
                'opacity-50 cursor-not-allowed': disabled,
                'cursor-pointer': !disabled
            }"
            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-200 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-primary-900 dark:focus:ring-offset-gray-800"
        >
            <span :class="{ 'translate-x-5': value === activeValue, 'translate-x-0': value === inactiveValue }" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" aria-hidden="true"></span>
        </button>
    </div>
</div>
