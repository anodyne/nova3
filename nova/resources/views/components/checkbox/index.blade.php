@props([
    'color' => 'primary',
])

@php
    $color = ($color === 'primary' && settings('appearance.panda')) ? 'panda' : $color;
@endphp

<span data-slot="control" class="group inline-flex focus:outline-none" role="radio">
    <input type="checkbox" class="peer sr-only" {{ $attributes }} />

    <span
        @class([
            // Basic layout
            'group relative isolate flex size-[1.125rem] items-center justify-center rounded-[0.3125rem] sm:size-4',

            // Background color + shadow applied to inset pseudo element, so shadow blends with border in light mode
            'before:absolute before:inset-0 before:-z-10 before:rounded-[calc(0.3125rem-1px)] before:bg-white before:shadow',

            // Background color when checked
            'before:peer-checked:bg-[--checkbox-checked-bg]',

            // Background color is moved to control and shadow is removed in dark mode so hide `before` pseudo
            'dark:before:hidden',

            // Background color applied to control in dark mode
            'dark:bg-white/5 dark:peer-checked:bg-[--checkbox-checked-bg]',

            // Border
            'border border-gray-950/15 hover:border-gray-950/30 peer-checked:border-transparent peer-checked:bg-[--checkbox-checked-border] peer-checked:hover:border-transparent',
            'dark:border-white/15 dark:hover:border-white/30 dark:peer-checked:border-white/5 dark:peer-checked:hover:border-white/5',

            // Inner highlight shadow
            'after:absolute after:inset-0 after:rounded-[calc(0.3125rem-1px)] after:shadow-[inset_0_1px_theme(colors.white/15%)]',
            'dark:after:-inset-px dark:after:hidden dark:after:rounded-[0.3125rem] dark:peer-checked:after:block',

            // Focus ring
            'group-data-[focus]:outline group-data-[focus]:outline-2 group-data-[focus]:outline-offset-2 group-data-[focus]:outline-blue-500',

            // Disabled state
            'peer-disabled:opacity-50',
            'peer-disabled:border-gray-950/25 peer-disabled:bg-gray-950/5 peer-disabled:[--checkbox-check:theme(colors.gray.950/50%)] peer-disabled:before:bg-transparent peer-disabled:hover:border-gray-950/25',
            'dark:peer-disabled:border-white/20 dark:peer-disabled:bg-white/[2.5%] dark:peer-disabled:[--checkbox-check:theme(colors.white/50%)] dark:peer-disabled:hover:border-white/20 dark:peer-disabled:peer-checked:after:hidden',

            // Forced color mode
            'forced-colors:[--checkbox-check:HighlightText] forced-colors:[--checkbox-checked-bg:Highlight] forced-colors:disabled:[--checkbox-check:Highlight]',
            'dark:forced-colors:[--checkbox-check:HighlightText] dark:forced-colors:[--checkbox-checked-bg:Highlight] dark:forced-colors:disabled:[--checkbox-check:Highlight]',

            match ($color) {
                'panda' => '[--checkbox-check:theme(colors.white)] [--checkbox-checked-bg:theme(colors.gray.900)] [--checkbox-checked-border:theme(colors.gray.950/90%)] dark:[--checkbox-checked-bg:theme(colors.gray.600)]',
                default => '[--checkbox-check:theme(colors.white)] [--checkbox-checked-bg:theme(colors.primary.500)] [--checkbox-checked-border:theme(colors.primary.600/80%)]',
            },
        ])
    >
        <svg
            class="size-4 stroke-[--checkbox-check] opacity-0 peer-checked:group-[]:opacity-100 sm:h-3.5 sm:w-3.5"
            viewBox="0 0 14 14"
            fill="none"
        >
            <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </span>
</span>
