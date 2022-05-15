@props([
    'label' => false,
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center space-x-2">
    <input type="radio" {{ $attributes->merge(['class' => 'rounded-full bg-white dark:bg-gray-700 checked:bg-blue-500 dark:checked:bg-blue-500 border-gray-200 dark:border-transparent focus:ring-blue-300 dark:focus:ring-blue-700 focus:ring-offset-white dark:focus:ring-offset-gray-800 checked:hover:bg-blue-500 dark:checked:hover:bg-blue-500 focus:text-blue-500']) }} @checked($checked)>

    @if ($label)
        <span class="text-gray-600 dark:text-gray-400">{{ $label }}</span>
    @endif
</label>
