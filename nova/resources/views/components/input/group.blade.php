@props([
    'label' => false,
    'for' => false,
    'help' => false,
    'error' => false,
])

<div {{ $attributes->merge(['class' => $error ? 'has-error' : '']) }}>
    @if ($label)
        <label for="{{ $for }}" class="block mb-1 text-sm font-medium text-gray-11">
            {{ $label }}
        </label>
    @endif

    {{ $slot }}

    @if ($error)
        <p class="flex items-center w-full relative mt-2 ml-0.5 text-sm text-red-11 space-x-1" role="alert">
            @icon('alert', 'h-6 w-6 flex-shrink-0 text-red-9')
            <span>{{ $error }}</span>
        </p>
    @endif

    @if ($help)
        <p class="block w-full relative mt-2 ml-0.5 text-sm text-gray-11" role="note">
            {{ $help }}
        </p>
    @endif
</div>
