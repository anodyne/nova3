@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

@aware(['error'])

<div
    @class([
        'ring-gray-300 focus-within:ring-primary-400 dark:ring-gray-200/[15%] dark:focus-within:ring-primary-700' => !$error,
        'ring-error-400 dark:ring-error-600 focus-within:ring-error-400 dark:focus-within:ring-error-600' => $error,
        'group relative flex items-center relative w-full rounded-md py-2 px-3 bg-white dark:bg-gray-700/50 dark:focus-within:bg-gray-800 shadow-sm transition space-x-2 ring-1 focus-within:ring-2'
    ])
    {{ $attributes }}
>
    @if ($leadingAddOn)
        <div class="flex items-center shrink-0 text-gray-500 dark:text-gray-400 sm:text-sm">
            {{ $leadingAddOn }}
        </div>
    @endif

    {{ $slot }}

    @if ($trailingAddOn || $error)
        <div
            @class([
                'text-error-500' => $error,
                'text-gray-400' => !$error,
                'flex items-center shrink-0 dark:text-gray-500 sm:text-sm'
            ])
        >
            @if ($error)
                @icon('alert', 'h-5 w-5 shrink-0')
            @else
                {{ $trailingAddOn }}
            @endif
        </div>
    @endif
</div>
