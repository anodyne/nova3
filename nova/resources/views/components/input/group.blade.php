@props([
    'label' => false,
    'for' => false,
    'help' => false,
    'error' => false,
])

<div {{ $attributes->merge(['class' => $error ? 'has-error' : '']) }}>
    @if ($label)
        <label for="{{ $for }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif

    {{ $slot }}

    @if ($error)
        <p
            class="relative ml-0.5 mt-2 flex w-full items-center space-x-1 text-base font-medium text-danger-500 md:text-sm"
            role="alert"
        >
            <span>{{ $error }}</span>
        </p>
    @endif

    @if ($help)
        <p class="relative ml-0.5 mt-2 block w-full text-base text-gray-500 dark:text-gray-400 md:text-sm" role="note">
            {{ $help }}
        </p>
    @endif
</div>
