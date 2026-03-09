@props([
    'active' => false,
    'meta' => null,
    'trailing' => null,
])

@php
    $tag = $attributes->has('href') ? 'a' : 'button';
@endphp

<span class="relative">
    <{{ $tag }}
        {{
            $attributes->class([
                // Base
                'relative flex w-full items-center gap-3 rounded-lg px-2 py-2.5 text-left text-base/6 font-medium text-gray-950 sm:py-2 sm:text-sm/5',

                // Leading icon/icon-only
                '*:data-[slot=icon]:size-6 *:data-[slot=icon]:shrink-0 *:data-[slot=icon]:text-gray-500 sm:*:data-[slot=icon]:size-5',

                // Trailing icon (down chevron or similar)
                '*:last:data-[slot=icon]:ml-auto *:last:data-[slot=icon]:size-5 sm:*:last:data-[slot=icon]:size-4',

                // Avatar
                '*:data-[slot=avatar]:-m-0.5 *:data-[slot=avatar]:size-7 sm:*:data-[slot=avatar]:size-6',

                // Hover
                'hover:bg-gray-950/5 hover:*:data-[slot=icon]:text-gray-950',

                // Active
                'active:bg-gray-950/5 active:*:data-[slot=icon]:text-gray-950',

                // Focus
                'focus:outline-none',

                // Current
                'data-current:bg-gray-950/5 data-current:*:data-[slot=icon]:text-gray-950',
                'dark:data-current:bg-white/5 dark:data-current:*:data-[slot=icon]:text-white',

                // Dark mode
                'dark:text-white dark:*:data-[slot=icon]:text-gray-400',
                'dark:hover:bg-white/5 dark:hover:*:data-[slot=icon]:text-white',
                'dark:active:bg-white/5 dark:active:*:data-[slot=icon]:text-white',
                'dark:data-current:*:data-[slot=icon]:text-white',
            ])
        }}
        {{ $active ? 'data-current' : false }}
        {{ $attributes->has('href') ? 'wire:navigate.hover' : null }}
    >
        {{ $slot }}

        @if (filled($trailing))
            <div class="absolute right-2 shrink-0">
                {{ $trailing }}
            </div>
        @endif
    </{{ $tag }}>
</span>

@if ($active && $meta?->subnav)
    <aside class="pl-4">
        @include($meta?->subnav)
    </aside>
@endif
