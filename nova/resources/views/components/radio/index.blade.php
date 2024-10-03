@props([
    'color' => 'primary',
])

@php
    $color = ($color === 'primary' && settings('appearance.panda')) ? 'panda' : $color;
@endphp

<span data-slot="control" class="group inline-flex focus:outline-none" role="radio">
    <input type="radio" class="peer sr-only" {{ $attributes }} />

    <label
        for="{{ $attributes->get('id') }}"
        @class([
            // Basic layout
            'relative isolate flex size-[1.1875rem] shrink-0 items-center justify-center rounded-full sm:size-[1.0625rem]',

            // Background color + shadow applied to inset pseudo element, so shadow blends with border in light mode
            'before:absolute before:inset-0 before:-z-10 before:rounded-full before:bg-white before:shadow',

            // Background color when checked
            'before:peer-checked:bg-[--radio-checked-bg]',

            // Background color is moved to control and shadow is removed in dark mode so hide `before` pseudo
            'dark:before:hidden',

            // Background color applied to control in dark mode
            'dark:bg-white/5 dark:peer-checked:bg-[--radio-checked-bg]',

            // Border
            'border border-gray-950/15 hover:border-gray-950/30 peer-checked:border-transparent peer-checked:bg-[--radio-checked-border] peer-checked:hover:border-transparent',
            'dark:border-white/15 dark:hover:border-white/30 dark:peer-checked:border-white/5 dark:peer-checked:hover:border-white/5',

            // Inner highlight shadow
            'after:absolute after:inset-0 after:rounded-full after:shadow-[inset_0_1px_theme(colors.white/15%)]',
            'dark:after:-inset-px dark:after:hidden dark:after:rounded-full dark:peer-checked:after:block',

            // Indicator color (light mode)
            '[--radio-indicator:transparent] hover:[--radio-indicator:theme(colors.gray.900/10%)] peer-checked:[--radio-indicator:var(--radio-checked-indicator)] peer-checked:hover:[--radio-indicator:var(--radio-checked-indicator)]',

            // Indicator color (dark mode)
            'dark:hover:[--radio-indicator:theme(colors.gray.700)] dark:peer-checked:hover:[--radio-indicator:var(--radio-checked-indicator)]',

            // Focus ring
            'group-data-[focus]:outline group-data-[focus]:outline-2 group-data-[focus]:outline-offset-2 group-data-[focus]:outline-blue-500',

            // Disabled state
            'peer-disabled:opacity-50',
            'peer-disabled:border-gray-950/25 peer-disabled:bg-gray-950/5 peer-disabled:[--radio-checked-indicator:theme(colors.gray.950/50%)] peer-disabled:before:bg-transparent peer-disabled:hover:border-gray-950/25',
            'dark:peer-disabled:border-white/20 dark:peer-disabled:bg-white/[2.5%] dark:peer-disabled:[--radio-checked-indicator:theme(colors.white/50%)] dark:peer-disabled:hover:border-white/20 dark:peer-disabled:peer-checked:after:hidden',

            // Forced color mode
            'forced-colors:[--radio-checked-bg:Highlight] forced-colors:disabled:[--radio-checked-indicator:Highlight]',
            'dark:forced-colors:[--radio-checked-bg:Highlight] dark:forced-colors:disabled:[--radio-checked-indicator:Highlight]',

            match ($color) {
                'panda' => '[--radio-checked-bg:theme(colors.gray.900)] [--radio-checked-border:theme(colors.gray.950/90%)] [--radio-checked-indicator:theme(colors.white)] dark:[--radio-checked-bg:theme(colors.gray.600)]',
                default => '[--radio-checked-bg:theme(colors.primary.500)] [--radio-checked-border:theme(colors.primary.600/80%)] [--radio-checked-indicator:theme(colors.white)]',
            },
        ])
    >
        <span class="size-[0.375rem] rounded-full bg-[--radio-indicator]"></span>
    </label>
</span>
