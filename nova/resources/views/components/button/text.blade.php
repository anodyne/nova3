@props([
    'tag' => 'button',
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'none',
    'color' => 'primary',
])

@php($tag = $attributes->has('href') ? 'a' : $tag)

<{{ $tag }}
    {{
        $attributes->merge([
            'type' => ($tag === 'button') ? $type : null,
        ])->class([
            'relative isolate inline-flex items-center justify-center gap-1.5 text-center font-medium transition',
            match ($size) {
                'xs' => 'px-[calc(theme(spacing.2)-1px)] py-[calc(theme(spacing.[0.5])-1px)] text-xs/5',
                'sm' => 'px-[calc(theme(spacing.[2.5])-1px)] py-[calc(theme(spacing.1)-1px)] text-sm/5',
                'none-xs' => 'text-xs',
                'none' => 'text-sm',
                'none-base' => 'text-base',
                'none-lg' => 'text-lg',
                default => 'px-[calc(theme(spacing.3)-1px)] py-[calc(theme(spacing.[1.5])-1px)] text-sm/6',
            },
            match ($color) {
                'primary' => 'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400',
                'danger' => 'text-danger-500 hover:text-danger-600 dark:hover:text-danger-400',
                'warning' => 'text-warning-700 hover:text-warning-800 dark:text-warning-500 dark:hover:text-warning-400',
                'heavy-neutral' => 'text-gray-600 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-200',
                'neutral-primary' => 'text-gray-500 hover:text-primary-500 dark:text-gray-400 dark:hover:text-primary-500',
                'neutral-danger' => 'text-gray-500 hover:text-danger-500 dark:text-gray-400 dark:hover:text-danger-500',
                'subtle-neutral' => 'text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400',
                'subtle-neutral-primary' => 'text-gray-400 hover:text-primary-500 dark:text-gray-600 dark:hover:text-primary-500',
                'subtle-neutral-danger' => 'text-gray-400 hover:text-danger-500 dark:text-gray-600 dark:hover:text-danger-500',
                default => 'text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300',
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
