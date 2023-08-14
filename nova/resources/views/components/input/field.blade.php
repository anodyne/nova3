@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

@aware(['error'])

<div
    @class([
        'group relative flex w-full items-center space-x-2 rounded-md bg-white px-3 py-2.5 shadow-sm ring-1 ring-inset transition focus-within:ring-2 focus-within:ring-inset dark:bg-opacity-5',
        'ring-gray-300 focus-within:ring-primary-600 dark:ring-white/10 dark:focus-within:ring-primary-500' => ! $error,
        'ring-danger-600 focus-within:ring-danger-600 dark:ring-danger-500 dark:focus-within:ring-danger-500' => $error,
    ])
    {{ $attributes }}
>
    @if ($leadingAddOn)
        <div class="flex shrink-0 items-center text-gray-400 sm:text-sm">
            {{ $leadingAddOn }}
        </div>
    @endif

    {{ $slot }}

    @if ($trailingAddOn || $error)
        <div
            @class([
                'text-danger-500' => $error,
                'text-gray-400' => ! $error,
                'flex shrink-0 items-center dark:text-gray-500 sm:text-sm',
            ])
        >
            @if ($error)
                <x-icon name="alert" size="sm" class="shrink-0"></x-icon>
            @else
                {{ $trailingAddOn }}
            @endif
        </div>
    @endif
</div>
