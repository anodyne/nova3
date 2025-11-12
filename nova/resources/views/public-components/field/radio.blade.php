@props([
    'value',
    'label' => null,
    'description' => null,
])

<div
    @class([
        'nova-field-radio-ctn relative flex',
        'items-start' => filled($description),
        'items-center' => blank($description),
    ])
>
    <div class="nova-field-radio-wrapper flex h-6 items-center">
        <input
            type="radio"
            value="{{ $value }}"
            {{
                $attributes->class([
                    'nova-field-radio',
                    'relative size-4 appearance-none rounded-full',
                    'border border-gray-300 bg-white',
                    'before:absolute before:inset-1 before:rounded-full before:bg-white',

                    // Hide the dot if not checked
                    'not-checked:before:hidden',

                    // Checked state
                    'checked:border-blue-600 checked:bg-blue-600',

                    // Focused state
                    'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600',

                    // Disabled state
                    'disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400',

                    // Dark
                    'dark:border-white/10 dark:bg-white/5 dark:checked:border-indigo-500 dark:checked:bg-indigo-500 dark:focus-visible:outline-indigo-500 dark:disabled:border-white/5 dark:disabled:bg-white/10 dark:disabled:before:bg-white/20',
                ])
            }}
        />
    </div>

    <div class="nova-field-radio-content ml-3 text-sm/6">
        @if (filled($label))
            <label
                class="nova-field-label font-medium text-gray-900 dark:text-white"
                for="{{ data_get($attributes, 'id') }}"
            >
                {{ $label }}
            </label>
        @endif

        @if (filled($description))
            <p class="nova-field-description m-0 text-gray-500">{{ $description }}</p>
        @endif
    </div>
</div>
