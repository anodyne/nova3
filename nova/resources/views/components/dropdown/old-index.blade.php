@props([
    'trigger' => null,
    'placement' => 'bottom start',
    'size' => 'lg',
])

<el-dropdown>
    {{ $trigger }}

    <el-menu
        anchor="{{ $placement }}"
        popover
        {{
            $attributes->class([
                '[--anchor-gap:--spacing(2)]',
                'divide-y divide-white/10 rounded-xl bg-gray-950 shadow-lg ring-1 ring-black',
                match ($size) {
                    'xs' => 'w-40',
                    'sm' => 'w-48',
                    'md' => 'w-52',
                    'lg' => 'w-60',
                    'xl' => 'w-72',
                    default => null,
                },
                match ($placement) {
                    'bottom start' => 'origin-top-left',
                    'bottom end' => 'origin-top-right',
                    default => null,
                },
                'focus:outline-hidden',
                'transition transition-discrete',
                'data-closed:scale-95 data-closed:transform data-closed:opacity-0',
                'data-enter:duration-100 data-enter:ease-out',
                'data-leave:duration-75 data-leave:ease-in',
            ])
        }}
    >
        {{ $slot }}
    </el-menu>
</el-dropdown>
