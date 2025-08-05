@props([
    'leading' => false,
    'trailing' => false,
])

@aware(['error'])

<div
    @class([
        'group dark:bg-opacity-5 relative flex w-full items-center space-x-2 rounded-lg bg-white px-3 py-2.5 shadow-sm ring-1 transition ring-inset focus-within:ring-2 focus-within:ring-inset',
        'focus-within:ring-primary-600 dark:focus-within:ring-primary-500 ring-gray-300 dark:ring-white/10' => ! $error,
        'ring-danger-600 focus-within:ring-danger-600 dark:ring-danger-500 dark:focus-within:ring-danger-500' => $error,
    ])
    {{ $attributes }}
>
    @if ($leading)
        <div class="flex shrink-0 items-center text-gray-400 sm:text-sm">
            {{ $leading }}
        </div>
    @endif

    {{ $slot }}

    @if ($trailing || $error)
        <div
            @class([
                'text-danger-500' => $error,
                'text-gray-400' => ! $error,
                'flex shrink-0 items-center sm:text-sm dark:text-gray-500',
            ])
        >
            @if ($error)
                <x-icon :name="Icon::AlertCircle" size="sm" class="shrink-0"></x-icon>
            @else
                {{ $trailing }}
            @endif
        </div>
    @endif
</div>
