@props([
    'tag' => 'button',
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'md',
    'color' => 'primary',
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
            'border border-transparent bg-[--button-border] dark:bg-[--button-border]',
            'before:absolute before:inset-0 before:-z-10 before:rounded-[calc(theme(borderRadius.md)-1px)] before:bg-[--button-bg]',
            'before:shadow dark:shadow',
            'dark:border-white/15 dark:ring-1 dark:ring-black/50',
            'after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.md)-1px)] after:bg-white after:bg-opacity-50 after:shadow-[inset_0_1px_theme(colors.white/15%)] after:hover:bg-opacity-0 dark:after:-inset-px dark:after:rounded-md dark:after:bg-gray-950 dark:after:bg-opacity-[65%] dark:after:shadow-[inset_0_1px_theme(colors.white/10%)] dark:after:hover:bg-opacity-50',
            'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500',
            match ($color) {
                'danger' => 'text-danger-600 [--button-bg:theme(colors.danger.50)] [--button-border:theme(colors.danger.300/80%)] before:shadow-danger-500/20 dark:[--button-bg:theme(colors.danger.950)]',
                'warning' => 'text-warning-600 [--button-bg:theme(colors.warning.50)] [--button-border:theme(colors.warning.300/80%)] before:shadow-warning-500/20 dark:[--button-bg:theme(colors.warning.950)]',
                default => 'text-primary-600 [--button-bg:theme(colors.primary.50)] [--button-border:theme(colors.primary.300/80%)] before:shadow-primary-500/20 dark:[--button-bg:theme(colors.primary.900)] dark:[--button-border:theme(colors.primary.300/80%)]',
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
