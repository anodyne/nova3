@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

@aware(['error'])

<div
    @class([
        'group relative flex items-center w-full rounded-md py-2.5 px-3 bg-white dark:bg-opacity-5 shadow-sm transition space-x-2 ring-1 ring-inset focus-within:ring-2 focus-within:ring-inset',
        'ring-gray-300 focus-within:ring-primary-600 dark:ring-white/10 dark:focus-within:ring-primary-500' => !$error,
        'ring-danger-600 dark:ring-danger-500 focus-within:ring-danger-600 dark:focus-within:ring-danger-500' => $error,
    ])
    {{ $attributes }}
>
    @if ($leadingAddOn)
        <div class="flex items-center shrink-0 text-gray-500 sm:text-sm">
            {{ $leadingAddOn }}
        </div>
    @endif

    {{ $slot }}

    @if ($trailingAddOn || $error)
        <div
            @class([
                'text-danger-500' => $error,
                'text-gray-400' => !$error,
                'flex items-center shrink-0 dark:text-gray-500 sm:text-sm'
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
