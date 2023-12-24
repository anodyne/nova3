@props([
    'label' => false,
    'for' => false,
    'checked' => false,
    'help' => false,
])

<div class="relative flex items-start">
    <div class="flex h-5 items-center">
        <input
            aria-describedby="{{ $attributes->get('id', $for) }}-description"
            type="checkbox"
            @class([
                'form-checkbox size-4 rounded',
                'border-gray-300 bg-white checked:bg-primary-500 checked:hover:bg-primary-500 focus:text-primary-500 focus:ring-primary-200 focus:ring-offset-white',
                'dark:border-gray-200/[15%] dark:bg-gray-800 dark:checked:border-primary-500 dark:checked:bg-primary-500 dark:checked:hover:bg-primary-500 dark:focus:text-primary-500 dark:focus:ring-primary-900 dark:focus:ring-offset-gray-800',
            ])
            {{ $attributes }}
            @checked($checked)
        />
    </div>

    @if ($label || $help)
        <div class="ml-3 text-sm">
            <label for="{{ $attributes->get('id', $for) }}" class="font-medium text-gray-700 dark:text-gray-300">
                {{ $label }}
            </label>

            @if ($help)
                <p id="{{ $attributes->get('id', $for) }}-description" class="text-gray-500">{{ $help }}</p>
            @endif
        </div>
    @endif
</div>
