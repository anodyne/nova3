@props([
    'label' => false,
    'for' => false,
    'help' => false,
    'error' => false,
])

<div {{ $attributes->merge(['class' => $error ? 'has-error' : '']) }}>
    @if ($label)
        <label for="{{ $for }}" class="block mb-1 text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    {{ $slot }}

    @if ($error)
        <p class="flex items-center w-full relative mt-2 ml-0.5 text-sm text-red-600 space-x-2" role="alert">
            @icon('alert', 'h-5 w-5 flex-shrink-0 text-red-400')
            <span>{{ $error }}</span>
        </p>
    @endif

    @if ($help)
        <p class="block w-full relative mt-2 ml-0.5 text-sm text-gray-500" role="note">
            {{ $help }}
        </p>
    @endif
</div>
