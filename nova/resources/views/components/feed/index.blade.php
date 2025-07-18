<ul
    role="feed"
    {{
        $attributes->class([
            'relative flex flex-col gap-12 py-12 pl-6 before:absolute before:left-6 before:top-0 before:h-full before:-translate-x-1/2 before:border before:border-dashed before:border-gray-200 after:absolute after:bottom-6 after:left-6 after:top-6 after:-translate-x-1/2 after:border after:border-gray-200 dark:before:border-gray-800 dark:after:border-gray-800',
        ])
    }}
>
    {{ $slot }}
</ul>
