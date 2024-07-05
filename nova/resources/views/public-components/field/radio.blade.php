@props([
    'name',
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
            name="{{ $name }}"
            value="{{ $value }}"
            {{
                $attributes->class([
                    'nova-field-radio size-4',
                    'border-gray-300 text-primary-600 focus:ring-primary-600',
                    'dark:border-gray-700 dark:text-primary-400 dark:focus:ring-primary-400',
                ])
            }}
        />
    </div>

    <div class="nova-field-radio-content ml-3 text-sm/6">
        @if (filled($label))
            <label class="nova-field-label font-medium text-gray-900 dark:text-white">{{ $label }}</label>
        @endif

        @if (filled($description))
            <p class="nova-field-description text-gray-500 m-0">{{ $description }}</p>
        @endif
    </div>
</div>
