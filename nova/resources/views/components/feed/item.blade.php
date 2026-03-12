@props([
    'dotColor' => null,
    'dotMask' => null,
])

@php
    $styleVars = [];

    if ($dotColor) {
        if ($dotColor && str($dotColor)->startsWith(['#', 'rgb', 'hsl'])) {
            $styleVars[] = "--feed-item-dot-color: {$dotColor}";
        }
    }

    if ($dotMask) {
        if ($dotMask && str($dotMask)->startsWith(['#', 'rgb', 'hsl'])) {
            $styleVars[] = "--feed-item-dot-mask: {$dotMask}";
        }
    }

    $style = count($styleVars) ? implode('; ', $styleVars) : null;
@endphp

<li
    role="article"
    {{
        $attributes
            ->merge(['style' => $style])
            ->class([
                'relative pl-6 before:absolute before:left-0 before:top-2 before:z-10 before:h-2.5 before:w-2.5 before:-translate-x-1/2 before:rounded-full before:ring-8',
                'before:bg-(--feed-item-dot-color)' => $dotColor,
                'before:bg-current' => ! $dotColor,
                'before:ring-(--feed-item-dot-mask)' => $dotMask,
                'before:ring-white dark:before:ring-gray-950' => ! $dotMask,
            ])
    }}
>
    <div class="flex flex-1 flex-col gap-4">
        {{ $slot }}
    </div>
</li>
