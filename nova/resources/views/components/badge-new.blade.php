@props([
    'color' => 'gray',
])

<span
    {{
        $attributes->class([
            'inline-flex items-center gap-x-1.5 rounded-md px-1.5 py-0.5 text-sm/5 font-medium lowercase tracking-normal sm:text-xs/5 forced-colors:outline',
            match ($color) {
                'danger' => 'bg-danger-500/15 text-danger-700 group-data-[hover]:bg-danger-500/25 dark:bg-danger-500/10 dark:text-danger-300 dark:group-data-[hover]:bg-danger-500/20',
                'info' => 'bg-info-500/15 text-info-700 group-data-[hover]:bg-info-500/25 dark:bg-info-500/10 dark:text-info-300 dark:group-data-[hover]:bg-info-500/20',
                'primary' => 'bg-primary-500/15 text-primary-700 group-data-[hover]:bg-primary-500/25 dark:bg-primary-500/10 dark:text-primary-300 dark:group-data-[hover]:bg-primary-500/20',
                'success' => 'bg-success-500/15 text-success-700 group-data-[hover]:bg-success-500/25 dark:bg-success-500/10 dark:text-success-300 dark:group-data-[hover]:bg-success-500/20',
                'warning' => 'bg-warning-500/15 text-warning-700 group-data-[hover]:bg-warning-500/25 dark:bg-warning-500/10 dark:text-warning-300 dark:group-data-[hover]:bg-warning-500/20',
                default => 'bg-gray-600/10 text-gray-700 group-data-[hover]:bg-gray-600/20 dark:bg-white/5 dark:text-gray-400 dark:group-data-[hover]:bg-white/10'
            },
        ])
    }}
>
    {{ $slot }}
</span>
