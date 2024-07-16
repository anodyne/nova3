@props([
    'active' => false,
    'meta' => null,
    'trailing' => null,
])

@php
    $tag = $attributes->has('href') ? 'a' : 'button';
@endphp

<span class="relative">
    {{--
        @if ($active)
        <span class="absolute inset-y-2 -left-4 w-0.5 rounded-full bg-primary-500"></span>
        @endif
    --}}

    <{{ $tag }}
        {{
            $attributes->class([
                // Base
                'flex w-full items-center gap-3 rounded-lg px-2 py-2.5 text-left text-base/6 font-medium text-gray-950 sm:py-2 sm:text-sm/5',

                // Leading icon/icon-only
                'data-[slot=icon]:*:size-6 data-[slot=icon]:*:shrink-0 data-[slot=icon]:*:text-gray-500 sm:data-[slot=icon]:*:size-5',

                // Trailing icon (down chevron or similar)
                'data-[slot=icon]:last:*:ml-auto data-[slot=icon]:last:*:size-5 sm:data-[slot=icon]:last:*:size-4',

                // Avatar
                'data-[slot=avatar]:*:-m-0.5 data-[slot=avatar]:*:size-7 data-[slot=avatar]:*:[--ring-opacity:10%] sm:data-[slot=avatar]:*:size-6',

                // Hover
                'hover:bg-gray-950/5 data-[slot=icon]:*:hover:text-gray-950',

                // Active
                'active:bg-gray-950/5 data-[slot=icon]:*:active:text-gray-950',

                // Current
                'data-[current]:bg-gray-950/5 data-[slot=icon]:*:data-[current]:text-gray-950',
                'dark:data-[current]:bg-white/5 dark:data-[slot=icon]:*:data-[current]:text-white',

                // Dark mode
                'dark:text-white dark:data-[slot=icon]:*:text-gray-400',
                'dark:hover:bg-white/5 dark:data-[slot=icon]:*:hover:text-white',
                'dark:active:bg-white/5 dark:data-[slot=icon]:*:active:text-white',
                'dark:data-[slot=icon]:*:data-[current]:text-white',
            ])
        }}
        {{ $active ? 'data-current' : false }}
        {{ $attributes->has('href') ? 'wire:navigate' : false }}
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
