<button
    type="button"
    data-slot="tab"
    @class([
        'flex flex-1 items-center justify-center gap-2 rounded-md px-4 text-sm font-medium whitespace-nowrap',

        // Inactive
        'text-gray-600 hover:text-gray-800',

        // Active
        'aria-selected:bg-white aria-selected:text-gray-800 aria-selected:shadow-sm aria-selected:ring-1 aria-selected:ring-gray-950/5',
    ])
    {{-- class="flex whitespace-nowrap flex-1 justify-center items-center gap-2 rounded-md  text-sm font-medium text-gray-600 hover:text-gray-800 dark:hover:text-white dark:text-white/70  dark:aria-selected:text-white  dark:aria-selected:bg-white/20 [&[disabled]]:opacity-50 dark:[&[disabled]]:opacity-75 [&[disabled]]:cursor-default [&[disabled]]:pointer-events-none px-4" --}}
>
    {{ $slot }}
</button>
