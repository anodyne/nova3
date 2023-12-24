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
            'relative isolate inline-flex items-center justify-center gap-x-2 rounded-lg border text-base/6 font-semibold',
            'focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500',
            'data-[disabled]:opacity-50',
            'forced-colors:[--btn-icon:ButtonText] forced-colors:hover:[--btn-icon:ButtonText] [&>[data-slot=icon]]:-mx-0.5 [&>[data-slot=icon]]:my-0.5 [&>[data-slot=icon]]:size-5 [&>[data-slot=icon]]:shrink-0 [&>[data-slot=icon]]:text-[--btn-icon] [&>[data-slot=icon]]:sm:my-1 [&>[data-slot=icon]]:sm:size-4',
            match ($size) {
                'xs' => 'px-[calc(theme(spacing[2.5])-1px)] py-[calc(theme(spacing[1.5])-1px)] sm:px-[calc(theme(spacing.2)-1px)] sm:py-[calc(theme(spacing[0.5])-1px)] sm:text-xs/5',
                'sm' => 'px-[calc(theme(spacing[3])-1px)] py-[calc(theme(spacing[2])-1px)] sm:px-[calc(theme(spacing.2.5)-1px)] sm:py-[calc(theme(spacing[1])-1px)] sm:text-sm/5',
                default => 'px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing.3)-1px)] sm:py-[calc(theme(spacing[1.5])-1px)] sm:text-sm/6',
            },
            'border-transparent bg-[--btn-border]',
            'dark:bg-[--btn-bg]',
            'before:absolute before:inset-0 before:-z-10 before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-[--btn-bg]',
            'before:shadow',
            'dark:before:hidden',
            'dark:border-white/5',
            'after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.lg)-1px)]',
            'after:shadow-[shadow:inset_0_1px_theme(colors.white/15%)]',
            'after:hover:bg-[--btn-hover-overlay] after:data-[active]:bg-[--btn-hover-overlay]',
            'dark:after:-inset-px dark:after:rounded-lg',
            'before:data-[disabled]:shadow-none after:data-[disabled]:shadow-none',
            match ($color) {
                'primary' => 'text-white [--btn-bg:theme(colors.primary.500)] [--btn-border:theme(colors.primary.600/80%)] [--btn-hover-overlay:theme(colors.white/10%)] [--btn-icon:theme(colors.white/60%)] hover:[--btn-icon:theme(colors.white/80%)] data-[active]:[--btn-icon:theme(colors.white/80%)]',
                'danger' => 'text-white [--btn-hover-overlay:theme(colors.white/10%)] [--btn-icon:theme(colors.white/60%)] [--btn-bg:theme(colors.danger.500)] [--btn-border:theme(colors.danger.600/80%)] hover:[--btn-icon:theme(colors.white/80%)] data-[active]:[--btn-icon:theme(colors.white/80%)]',
                'warning' => 'text-white [--btn-hover-overlay:theme(colors.white/10%)] [--btn-icon:theme(colors.white/60%)] [--btn-bg:theme(colors.warning.500)] [--btn-border:theme(colors.warning.600/80%)] hover:[--btn-icon:theme(colors.white/80%)] data-[active]:[--btn-icon:theme(colors.white/80%)]',
                default => 'text-gray-950 [--btn-bg:white] [--btn-border:theme(colors.gray.950/10%)] [--btn-hover-overlay:theme(colors.gray.950/2.5%)] [--btn-icon:theme(colors.gray.500)] hover:[--btn-border:theme(colors.gray.950/15%)] hover:[--btn-icon:theme(colors.gray.700)] data-[active]:[--btn-border:theme(colors.gray.950/15%)] data-[active]:[--btn-icon:theme(colors.gray.700)] dark:text-white dark:[--btn-bg:theme(colors.gray.800)] dark:[--btn-hover-overlay:theme(colors.white/5%)] dark:[--btn-icon:theme(colors.gray.500)] dark:hover:[--btn-icon:theme(colors.gray.400)] dark:data-[active]:[--btn-icon:theme(colors.gray.400)]',
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
