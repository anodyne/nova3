<button
    type="button"
    {{
        $attributes->class([
            // Basic layout
            'group relative block w-full',

            // Background color + shadow applied to inset pseudo element, so shadow blends with border in light mode
            'before:absolute before:inset-px before:rounded-[calc(var(--radius-lg)-1px)] before:bg-white before:shadow',

            // Background color is moved to control and shadow is removed in dark mode so hide `before` pseudo
            'dark:before:hidden',

            // Focus ring
            'sm:after:focus-within:ring-primary-500 after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:ring-transparent after:ring-inset sm:after:focus-within:ring-2',

            // Disabled state
            'has-data-disabled:opacity-50 before:has-data-disabled:bg-gray-950/5 before:has-data-disabled:shadow-none',
        ])
    }}
>
    <div
        @class([
            // Basic layout
            'relative block w-full appearance-none rounded-lg py-[calc(--spacing(2.5)-1px)] sm:py-[calc(--spacing(1.5)-1px)]',

            // Horizontal padding
            'pr-[calc(--spacing(10)-1px)] pl-[calc(--spacing(3.5)-1px)] sm:pr-[calc(--spacing(9)-1px)] sm:pl-[calc(--spacing(3)-1px)]',

            // Options (multi-select)
            '[&_optgroup]:font-semibold',

            // Typography
            'text-left text-base/6 text-gray-950 placeholder:text-gray-500 sm:text-sm/6 dark:text-white',

            // Border
            'border border-gray-950/10 hover:border-gray-950/20 dark:border-white/10 dark:hover:border-white/20',

            // Background color
            'bg-transparent dark:bg-white/5',

            // Hide default focus styles
            'focus:ring-0 focus:outline-none',

            // Invalid state
            'invalid:border-danger-500 invalid:hover:border-danger-500 invalid:dark:border-danger-600 invalid:hover:dark:border-danger-600',

            // Disabled state
            'disabled:border-gray-950/20 disabled:opacity-100 disabled:dark:border-white/15 disabled:dark:bg-white/[2.5%] dark:hover:disabled:border-white/15',
        ])
    >
        {{ $slot }}

        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
            <svg
                class="size-5 stroke-gray-500 group-has-data-disabled:stroke-gray-600 sm:size-4 dark:stroke-gray-400 forced-colors:stroke-[CanvasText]"
                viewBox="0 0 16 16"
                aria-hidden="true"
                fill="none"
            >
                <path
                    d="M5.75 10.75L8 13L10.25 10.75"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path d="M10.25 5.25L8 3L5.75 5.25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
    </div>
</button>
