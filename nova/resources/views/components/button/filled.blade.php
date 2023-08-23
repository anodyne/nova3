@props([
    'tag' => 'button',
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'md',
    'color' => 'neutral',
])

@php($tag = $attributes->has('href') ? 'a' : $tag)

<{{ $tag }}
    {{
        $attributes->merge([
            'type' => ($tag === 'button') ? $type : null,
        ])->class([
            'relative isolate inline-flex items-center justify-center gap-1.5 rounded-md text-center transition',
            match ($size) {
                'xs' => 'px-[calc(theme(spacing.2)-1px)] py-[calc(theme(spacing.[0.5])-1px)] text-xs/5 font-medium',
                'sm' => 'px-[calc(theme(spacing.[2.5])-1px)] py-[calc(theme(spacing.1)-1px)] text-sm/5 font-semibold',
                default => 'px-[calc(theme(spacing.3)-1px)] py-[calc(theme(spacing.[1.5])-1px)] text-sm/6 font-semibold',
            },
            'border border-transparent bg-[--button-border] dark:bg-[--button-bg]',
            'before:absolute before:inset-0 before:-z-10 before:rounded-[calc(theme(borderRadius.md)-1px)] before:bg-[--button-bg]',
            'before:shadow dark:shadow dark:before:hidden',
            'dark:border-white/10 dark:ring-1 dark:ring-black/50',
            'after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.md)-1px)] after:shadow-[inset_0_1px_theme(colors.white/15%)] after:hover:bg-white/10 dark:after:-inset-px dark:after:rounded-md',
            'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500',
            match ($color) {
                'primary' => 'text-white [--button-bg:theme(colors.primary.500)] [--button-border:theme(colors.primary.600/80%)]',
                'danger' => 'text-white [--button-bg:theme(colors.danger.500)] [--button-border:theme(colors.danger.600/80%)]',
                'warning' => 'text-white [--button-bg:theme(colors.warning.500)] [--button-border:theme(colors.warning.600/80%)]',
                default => 'text-gray-950 [--button-bg:theme(colors.white)] [--button-border:theme(colors.gray.950/10%)] hover:[--button-border:theme(colors.gray.950/20%)] dark:text-white dark:[--button-bg:theme(colors.gray.600)] dark:[--button-border:theme(colors.gray.800/90%)] dark:hover:[--button-border:theme(colors.gray.800/70%)]'
            },
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
