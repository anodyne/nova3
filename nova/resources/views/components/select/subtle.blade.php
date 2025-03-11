<span data-slot="control" class="relative">
    <select
        {{
            $attributes->class([
                // Basic layout
                'appearance-none rounded-lg border-none text-sm font-medium transition',

                // Vertical padding
                'py-[calc(theme(spacing[2.5])-1px)] sm:py-[calc(theme(spacing[1.5])-1px)]',

                // Horizontal padding
                'pl-[calc(theme(spacing[3.5])-1px)] pr-[calc(theme(spacing.10)-1px)] sm:pl-[calc(theme(spacing.3)-1px)] sm:pr-[calc(theme(spacing.9)-1px)]',

                // Hover
                'hover:bg-gray-950/5',
            ])
        }}
    >
        {{ $slot }}
    </select>

    <span class="pointer-events-none absolute inset-y-0 right-0 flex shrink-0 items-center pr-2.5">
        <svg
            class="size-5 stroke-gray-500 group-has-[[data-disabled]]:stroke-gray-600 sm:size-4 dark:stroke-gray-400 forced-colors:stroke-[CanvasText]"
            viewBox="0 0 16 16"
            aria-hidden="true"
            fill="none"
        >
            <path d="M5.75 10.75L8 13L10.25 10.75" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M10.25 5.25L8 3L5.75 5.25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </span>
</span>
