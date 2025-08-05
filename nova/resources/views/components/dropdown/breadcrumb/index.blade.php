@props([
    'trigger' => null,
    'placeholder' => null,
])

<el-dropdown>
    @if ($trigger?->isNotEmpty())
        <button
            type="button"
            class="flex items-center gap-x-2 rounded-lg px-2.5 py-1 hover:bg-gray-950/5 [&:has(+el-menu:popover-open)]:bg-gray-950/5"
        >
            {{ $trigger }}
            <x-icon.micro.chevron-up-down class="text-gray-400" />
        </button>
    @endif

    @if ($placeholder?->isNotEmpty())
        <div class="px-2.5 py-1">
            {{ $placeholder }}
        </div>
    @endif

    <el-menu
        anchor="bottom start"
        popover
        {{
            $attributes->class([
                '[--anchor-gap:--spacing(1.5)]',
                'rounded-xl bg-gray-950 p-1 shadow-lg ring-1 ring-black',
                'w-screen max-w-[14rem] origin-top-left',
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
