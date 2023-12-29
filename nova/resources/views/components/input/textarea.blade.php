{{-- format-ignore-start --}}
<span
    data-slot="control"
    @class([
        // Basic layout
        'relative block w-full',

        // Background color + shadow applied to inset pseudo element, so shadow blends with border in light mode
        'before:absolute before:inset-px before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-white before:shadow',

        // Background color is moved to control and shadow is removed in dark mode so hide `before` pseudo
        'dark:before:hidden',

        // Focus ring
        'after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:ring-inset after:ring-transparent sm:after:focus-within:ring-2',

        'sm:after:focus-within:ring-primary-500' => ! settings('appearance.panda'),
        'sm:after:focus-within:ring-gray-900 dark:sm:after:focus-within:ring-gray-500' => settings('appearance.panda'),

        // Disabled state
        'has-[[data-disabled]]:opacity-50 before:has-[[data-disabled]]:bg-gray-950/5 before:has-[[data-disabled]]:shadow-none',
    ])
>
    <textarea
        @class([
            // Basic layout
            'relative block h-full w-full appearance-none rounded-lg px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing.3)-1px)] sm:py-[calc(theme(spacing[1.5])-1px)]',

            // Typography
            'text-base/6 text-gray-950 placeholder:text-gray-500 sm:text-sm/6 dark:text-white',

            // Border
            'border border-gray-950/10 hover:border-gray-950/20 dark:border-white/10 dark:hover:border-white/20',

            // Background color
            'bg-transparent dark:bg-white/5',

            // Hide default focus styles
            'focus:outline-none focus:ring-0',

            // Invalid state
            'data-[invalid]:border-red-500 data-[invalid]:hover:border-red-500 data-[invalid]:dark:border-red-600 data-[invalid]:hover:dark:border-red-600',

            // Disabled state
            'disabled:border-gray-950/20 disabled:dark:border-white/15 disabled:dark:bg-white/[2.5%] dark:hover:disabled:border-white/15',

            $attributes->get('class'),
        ])
        {{ $attributes->merge(['rows' => 5]) }}
    >{{ $slot }}</textarea>
</span>
{{-- format-ignore-end --}}
