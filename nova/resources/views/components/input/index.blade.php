@aware(['error', 'name', 'id'])

<span
    data-slot="control"
    @class([
        // Basic layout
        'relative flex w-full gap-x-2',

        // Background color + shadow applied to inset pseudo element, so shadow blends with border in light mode
        'before:absolute before:inset-px before:rounded-[calc(var(--radius-lg)-1px)] before:bg-white before:shadow',

        // Background color is moved to control and shadow is removed in dark mode so hide `before` pseudo
        'dark:before:hidden',

        // Focus ring
        'after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:ring-transparent after:ring-inset sm:focus-within:after:ring-2',

        'sm:focus-within:after:ring-primary-500',

        // Disabled state
        'has-data-disabled:opacity-50 has-data-disabled:before:bg-gray-950/5 has-data-disabled:before:shadow-none',

        // Invalid state
        'has-data-invalid:before:shadow-danger-500/10',
    ])
>
    <input
        {{
            $attributes
                ->merge(['id' => $id, 'name' => $name, 'data-invalid' => filled($error)])
                ->class([
                    '[&::-webkit-date-and-time-value]:min-h-[1.5em] [&::-webkit-datetime-edit]:inline-flex [&::-webkit-datetime-edit]:p-0 [&::-webkit-datetime-edit-day-field]:p-0 [&::-webkit-datetime-edit-fields-wrapper]:p-0 [&::-webkit-datetime-edit-hour-field]:p-0 [&::-webkit-datetime-edit-meridiem-field]:p-0 [&::-webkit-datetime-edit-millisecond-field]:p-0 [&::-webkit-datetime-edit-minute-field]:p-0 [&::-webkit-datetime-edit-month-field]:p-0 [&::-webkit-datetime-edit-second-field]:p-0 [&::-webkit-datetime-edit-year-field]:p-0',

                    // Basic layout
                    'relative block w-full appearance-none rounded-lg px-[calc(--spacing(3.5)-1px)] py-[calc(--spacing(2.5)-1px)] sm:px-[calc(--spacing(3)-1px)] sm:py-[calc(--spacing(1.5)-1px)]',

                    // Typography
                    'text-base/6 text-gray-950 placeholder:text-gray-500 sm:text-sm/6 dark:text-white',

                    // Border
                    'border border-gray-950/10 hover:border-gray-950/20 dark:border-white/10 dark:hover:border-white/20',

                    // Background color
                    'bg-transparent dark:bg-white/5',

                    // Hide default focus styles
                    'focus:ring-0 focus:outline-none',

                    // Invalid state
                    'data-invalid:border-red-500 data-invalid:hover:border-red-500 data-invalid:dark:border-red-500 data-invalid:hover:dark:border-red-500',

                    // Disabled state
                    'disabled:border-gray-950/20 dark:disabled:border-white/15 dark:disabled:bg-white/[2.5%] dark:hover:disabled:border-white/15',
                ])
        }}
    />
</span>
