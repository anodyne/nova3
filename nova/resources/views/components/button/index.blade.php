@props([
    'tag' => 'button',
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'md',
])

@php($tag = $attributes->has('href') ? 'a' : $tag)

<{{ $tag }}
    {{
        $attributes->merge([
            'type' => ($tag === 'button') ? $type : null,
        ])->class([
            'relative isolate inline-flex cursor-pointer justify-center rounded-md text-center text-sm/6 font-semibold',
            'after:shadow-[shadow:inset_0_1px_theme(colors.white/15%),theme(boxShadow.DEFAULT)]',
            'border border-transparent',
            'before:absolute before:-inset-px before:-z-10 before:rounded-md before:bg-[--button-border]',
            'after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.md)-1px)] after:bg-[--button-bg]',
            'after:hover:bg-[color-mix(in_srgb,var(--button-bg),white_10%)]',
            match ($size) {
                'xs' => 'px-[calc(theme(spacing.[2.5])-1px)] py-[calc(theme(spacing.1)-1px)] text-xs/5',
                'sm' => 'px-[calc(theme(spacing.[2.5])-1px)] py-[calc(theme(spacing.1)-1px)] text-sm/5',
                default => 'px-[calc(theme(spacing.4)-1px)] py-[calc(theme(spacing.[2.5])-1px)] text-sm/6',
            },

            // 'group relative isolate inline-flex cursor-pointer items-center justify-center space-x-1.5 rounded-md text-center font-semibold transition',
            // 'after:shadow-[shadow:inset_0_1px_theme(colors.white/15%),theme(boxShadow.DEFAULT)]',
            // 'border border-transparent',
            // 'before:absolute before:-inset-px before:-z-10 after:rounded-[calc(theme(borderRadius.md)-1px)]',
            // 'px-2.5 py-1 text-xs' => $size === 'xs',
            // 'px-2.5 py-1 text-sm' => $size === 'sm',
            // 'px-[calc(theme(spacing.4)-1px)] py-[calc(theme(spacing.[2.5])-1px)] text-sm/6' => $size === 'md',
            // 'text-xs' => $size === 'none-xs',
            // 'text-sm' => $size === 'none',
            // 'text-base' => $size === 'none-base',
            $attributes->get('class'),
        ])
    }}
>
    @if ($leading)
        <span class="shrink-0">
            <x-icon :name="$leading" size="sm"></x-icon>
        </span>
    @endif

    <span class="w-full">{{ $slot }}</span>

    @if ($trailing)
        <span class="shrink-0">
            <x-icon :name="$trailing" size="sm"></x-icon>
        </span>
    @endif
</{{ $tag }}>
