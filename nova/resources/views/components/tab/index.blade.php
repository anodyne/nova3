<flux:tab
    {{
        $attributes->class([
            'z-10 mb-0! flex h-max cursor-pointer items-center justify-center gap-2 rounded-lg border-none px-3 py-2 text-sm font-semibold! whitespace-nowrap transition duration-100 ease-linear',
            'text-gray-500! hover:text-gray-700! dark:text-gray-400! dark:hover:text-gray-300!',

            // Selected (light mode)
            'data-selected:bg-white data-selected:text-gray-700! data-selected:shadow-xs data-selected:ring-1 data-selected:ring-gray-300 data-selected:ring-inset hover:data-selected:text-gray-700',

            // Selected (dark mode)
            'dark:data-selected:bg-gray-900 dark:data-selected:text-gray-300! dark:data-selected:shadow-xs dark:data-selected:ring-1 dark:data-selected:ring-gray-700 dark:data-selected:ring-inset dark:hover:data-selected:text-gray-300',
        ])
    }}
>
    {{ $slot }}
</flux:tab>
