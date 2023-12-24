@props([
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'base',
    'outline' => false,
    'plain' => false,
    'color' => 'neutral',
])

@php
    $tag = $attributes->has('href') ? 'a' : 'button';
    $variant = $outline ? 'outline' : ($plain ? 'plain' : 'solid');
@endphp

<{{ $tag }}
    {{
        $attributes->merge([
            'type' => ($tag === 'button') ? $type : null,
        ])->class([
            'relative isolate inline-flex items-center justify-center gap-x-2 rounded-lg border text-base/6 font-semibold',
            'focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500',
            'disabled:opacity-50',
            'forced-colors:[--btn-icon:ButtonText] forced-colors:hover:[--btn-icon:ButtonText] [&>[data-slot=icon]]:-mx-0.5 [&>[data-slot=icon]]:my-0.5 [&>[data-slot=icon]]:shrink-0 [&>[data-slot=icon]]:text-[--btn-icon] [&>[data-slot=icon]]:sm:my-1',
            // '[&>[data-slot=icon]]:size-5 [&>[data-slot=icon]]:sm:size-4',
            match ($size) {
                'xs' => 'px-[calc(theme(spacing.[2.5])-1px)] py-[calc(theme(spacing.1)-1px)] text-xs/5',
                'sm' => 'px-[calc(theme(spacing.[2.5])-1px)] py-[calc(theme(spacing.1)-1px)] text-sm/5',
                default => 'px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing.3)-1px)] sm:py-[calc(theme(spacing[1.5])-1px)] sm:text-sm/6',
            },
            match ($variant) {
                'solid' => 'border-transparent bg-[--btn-border] before:absolute before:inset-0 before:-z-10 before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-[--btn-bg] before:shadow after:absolute after:inset-0 after:-z-10 after:rounded-[calc(theme(borderRadius.lg)-1px)] after:shadow-[shadow:inset_0_1px_theme(colors.white/15%)] after:hover:bg-[--btn-hover-overlay] after:active:bg-[--btn-hover-overlay] before:disabled:shadow-none after:disabled:shadow-none dark:border-white/5 dark:bg-[--btn-bg] dark:before:hidden dark:after:-inset-px dark:after:rounded-lg',

                'outline' => 'border-gray-950/10 text-gray-950 [--btn-icon:theme(colors.gray.500)] hover:bg-gray-950/[2.5%] hover:[--btn-icon:theme(colors.gray.700)] active:bg-gray-950/[2.5%] active:[--btn-icon:theme(colors.gray.700)] dark:border-white/15 dark:text-white dark:[--btn-bg:transparent] dark:hover:bg-white/5 dark:hover:[--btn-icon:theme(colors.gray.400)] dark:active:bg-white/5 dark:active:[--btn-icon:theme(colors.gray.400)]',

                'plain' => 'border-transparent text-gray-950 [--btn-icon:theme(colors.gray.500)] hover:bg-gray-950/5 hover:[--btn-icon:theme(colors.gray.700)] active:bg-gray-950/5 active:bg-gray-950/5 active:[--btn-icon:theme(colors.gray.700)] active:[--btn-icon:theme(colors.gray.700)] dark:text-white dark:[--btn-icon:theme(colors.gray.500)] dark:hover:bg-white/10 dark:hover:[--btn-icon:theme(colors.gray.400)] dark:active:bg-white/10 dark:active:bg-white/10 dark:active:[--btn-icon:theme(colors.gray.400)] dark:active:[--btn-icon:theme(colors.gray.400)]',
            },
            match ($color) {
                'primary' => 'text-white [--btn-bg:theme(colors.primary.500)] [--btn-border:theme(colors.primary.600/80%)] [--btn-hover-overlay:theme(colors.white/10%)] [--btn-icon:theme(colors.white/60%)] hover:[--btn-icon:theme(colors.white/80%)] active:[--btn-icon:theme(colors.white/80%)]',
                'danger' => 'text-white [--btn-hover-overlay:theme(colors.white/10%)] [--btn-icon:theme(colors.white/60%)] [--btn-bg:theme(colors.danger.500)] [--btn-border:theme(colors.danger.600/80%)] hover:[--btn-icon:theme(colors.white/80%)] active:[--btn-icon:theme(colors.white/80%)]',
                'warning' => 'text-white [--btn-hover-overlay:theme(colors.white/10%)] [--btn-icon:theme(colors.white/60%)] [--btn-bg:theme(colors.warning.500)] [--btn-border:theme(colors.warning.600/80%)] hover:[--btn-icon:theme(colors.white/80%)] active:[--btn-icon:theme(colors.white/80%)]',
                default => 'text-gray-950 [--btn-icon:theme(colors.gray.500)] [--btn-bg:white] [--btn-border:theme(colors.gray.950/10%)] [--btn-hover-overlay:theme(colors.gray.950/2.5%)] hover:[--btn-icon:theme(colors.gray.700)] hover:[--btn-border:theme(colors.gray.950/15%)] active:[--btn-icon:theme(colors.gray.700)] active:[--btn-border:theme(colors.gray.950/15%)] dark:text-white dark:[--btn-icon:theme(colors.gray.500)] dark:[--btn-bg:theme(colors.gray.800)] dark:[--btn-hover-overlay:theme(colors.white/5%)] dark:hover:[--btn-icon:theme(colors.gray.400)] dark:active:[--btn-icon:theme(colors.gray.400)]',
            },
            $attributes->get('class'),
        ])
    }}
>
    {{ $slot }}
</{{ $tag }}>
