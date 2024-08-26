@props([
    'color' => 'gray',
    'size' => 'sm',
    'pill' => false,
])

<div
    data-slot="badge"
    {{
        $attributes->class([
            'nv-badge inline-flex items-center font-medium tracking-normal ring-1 ring-inset',
            '[&>[data-slot=icon]]:-mx-0.5 [&>[data-slot=icon]]:my-0.5 [&>[data-slot=icon]]:shrink-0 [&>[data-slot=icon]]:text-[--btn-icon] [&>[data-slot=icon]]:sm:my-1',
            '[&>[data-slot=badge]]:bg-white dark:[&>[data-slot=badge]]:bg-gray-950',
            match ($size) {
                'sm' => 'nv-badge-sm gap-x-2.5 rounded-md px-1.5 py-0.5 text-xs/5 has-[[data-slot=badge]]:rounded-lg data-[pill]:rounded-full data-[pill]:px-2 [&>[data-slot=badge]]:-mx-0.5 [&>[data-slot=badge]]:my-0.5 data-[pill]:[&>[data-slot=badge]]:-mx-1',
                'md' => 'nv-badge-md gap-x-3 rounded-md px-2 py-0.5 text-sm/5 has-[[data-slot=badge]]:rounded-lg data-[pill]:rounded-full data-[pill]:px-2.5 [&>[data-slot=badge]]:-mx-1 [&>[data-slot=badge]]:my-0.5 data-[pill]:[&>[data-slot=badge]]:-mx-1.5',
                'lg' => 'nv-badge-lg gap-x-3.5 rounded-lg px-2.5 py-1 text-sm/5 has-[[data-slot=badge]]:rounded-xl data-[pill]:rounded-full data-[pill]:px-3 [&>[data-slot=badge]]:-mx-1.5 data-[pill]:[&>[data-slot=badge]]:-mx-2',
            },
            match ($color) {
                'danger' => 'nv-badge-danger bg-danger-50 text-danger-700 ring-danger-200 [--btn-icon:theme(colors.danger.600)] dark:bg-danger-950 dark:text-danger-300 dark:ring-danger-800 dark:[--btn-icon:theme(colors.danger.400)]',
                'info' => 'nv-badge-info bg-info-50 text-info-700 ring-info-200 [--btn-icon:theme(colors.info.600)] dark:bg-info-950 dark:text-info-300 dark:ring-info-800 dark:[--btn-icon:theme(colors.info.400)]',
                'primary' => 'nv-badge-primary bg-primary-50 text-primary-700 ring-primary-200 [--btn-icon:theme(colors.primary.600)] dark:bg-primary-950 dark:text-primary-300 dark:ring-primary-800 dark:[--btn-icon:theme(colors.primary.400)]',
                'success' => 'nv-badge-success bg-success-50 text-success-700 ring-success-200 [--btn-icon:theme(colors.success.600)] dark:bg-success-950 dark:text-success-300 dark:ring-success-800 dark:[--btn-icon:theme(colors.success.400)]',
                'warning' => 'nv-badge-warning bg-warning-50 text-warning-700 ring-warning-200 [--btn-icon:theme(colors.warning.600)] dark:bg-warning-950 dark:text-warning-300 dark:ring-warning-800 dark:[--btn-icon:theme(colors.warning.400)]',
                default => 'bg-gray-50 text-gray-700 ring-gray-200 [--btn-icon:theme(colors.gray.600)] dark:bg-gray-900 dark:text-gray-300 dark:ring-gray-700 dark:[--btn-icon:theme(colors.gray.400)]',
            },
        ])
    }}
    @if ($pill) data-pill @endif
>
    {{ $slot }}
</div>
