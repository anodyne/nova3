<main
    data-slot="sidebar-inset"
    {{
        $attributes->class([
            'bg-background relative flex w-full flex-1 flex-col',
            'md:peer-data-[variant=inset]:m-2 md:peer-data-[variant=inset]:ml-0.5 md:peer-data-[variant=inset]:rounded-lg md:peer-data-[variant=inset]:shadow-sm md:peer-data-[variant=inset]:ring-1 md:peer-data-[variant=inset]:ring-border',
        ])
    }}
>
    {{ $slot }}
</main>
