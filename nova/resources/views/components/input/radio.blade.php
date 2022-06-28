@props([
    'label' => false,
    'for' => false,
    'checked' => false,
    'help' => false,
])

<div class="relative flex items-start">
    <div class="flex items-center h-5">
        <input
            aria-describedby="{{ $attributes->get('id', $for) }}-description"
            type="radio"
            @class([
                'form-radio rounded-full h-4 w-4',
                'bg-white checked:bg-primary-500 border-gray-300 focus:ring-primary-100 focus:ring-offset-white checked:hover:bg-primary-500 focus:text-primary-500',
                'dark:bg-gray-800 dark:checked:bg-primary-500 dark:border-gray-200/[15%] dark:checked:border-primary-500 dark:focus:ring-primary-900 dark:focus:ring-offset-gray-800 dark:checked:hover:bg-primary-500 dark:focus:text-primary-500',
            ])
            {{ $attributes }}
            @checked($checked)
        >
    </div>

    @if ($label || $help)
        <div class="ml-3 text-sm">
            <label for="{{ $attributes->get('id', $for) }}" class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>

            @if ($help)
                <p id="{{ $attributes->get('id', $for) }}-description" class="text-gray-500">{{ $help }}</p>
            @endif
        </div>
    @endif
</div>
