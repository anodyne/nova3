@props(['icon' => null])

<header
    data-slot="frame-panel-header"
    {{
        $attributes->class([
            'grid items-center px-5 py-4',
            'grid-cols-[auto_1fr] gap-3' => isset($icon),
            'grid-cols-1' => ! isset($icon),
        ])
    }}
>
    @isset($icon)
        <div class="*:text-color-500">
            {{ $icon }}
        </div>
    @endisset

    <div class="flex flex-col">
        {{ $slot }}
    </div>
</header>
