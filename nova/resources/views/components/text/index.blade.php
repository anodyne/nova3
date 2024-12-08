@props([
    'size' => 'base',
    'tag' => 'p',
    'color' => null,
])

<{{ $tag }}
    data-slot="text"
    {{
        $attributes->class([
            match ($color) {
                'danger' => 'text-danger-600 dark:text-danger-400',
                'info' => 'text-info-600 dark:text-info-400',
                'success' => 'text-success-600 dark:text-success-400',
                'warning' => 'text-warning-600 dark:text-warning-400',
                default => 'text-gray-600 dark:text-gray-300',
            },
            match ($size) {
                'sm' => 'text-sm/5 sm:text-xs/5',
                'lg' => 'text-lg/7 sm:text-base/7',
                'xl' => 'text-xl/8 sm:text-lg/8',
                default => 'text-base/6 sm:text-sm/6',
            },
        ])
    }}
>
    {{ $slot }}
</{{ $tag }}>
