@props([
    'active' => false,
    'meta' => null,
    'trailing' => null,
])

@php
    $tag = $attributes->has('href') ? 'a' : 'button';
@endphp

<span class="relative">
    @if ($active)
        <span class="absolute inset-x-2 -bottom-2.5 h-0.5 rounded-full bg-primary-500"></span>
    @endif

    <{{ $tag }}
        {{
            $attributes->class([
                // Base
                'relative flex min-w-0 items-center gap-3 rounded-lg p-2 text-left text-base/6 font-medium text-gray-950 sm:text-sm/5',

                // Leading icon/icon-only
                'data-[slot=icon]:*:size-6 data-[slot=icon]:*:shrink-0 data-[slot=icon]:*:text-gray-500 sm:data-[slot=icon]:*:size-5',

                // Trailing icon (down chevron or similar)
                // 'data-[slot=icon]:last:[&:not(:nth-child(2))]:*:ml-auto data-[slot=icon]:last:[&:not(:nth-child(2))]:*:size-5 sm:data-[slot=icon]:last:[&:not(:nth-child(2))]:*:size-4',

                // Avatar
                'data-[slot=avatar]:*:-m-0.5 data-[slot=avatar]:*:size-7 data-[slot=avatar]:*:[--avatar-radius:theme(borderRadius.DEFAULT)] data-[slot=avatar]:*:[--ring-opacity:10%] sm:data-[slot=avatar]:*:size-6',

                // Hover
                'hover:bg-gray-950/5 data-[slot=icon]:*:hover:text-gray-950',

                // Active
                'active:bg-gray-950/5 data-[slot=icon]:*:active:text-gray-950',

                // Focus
                'focus:outline-none',

                // Dark mode
                'dark:text-white dark:data-[slot=icon]:*:text-gray-400',
                'dark:hover:bg-white/5 dark:data-[slot=icon]:*:hover:text-white',
                'dark:active:bg-white/5 dark:data-[slot=icon]:*:active:text-white',
            ])
        }}
    >
        {{ $slot }}
    </{{ $tag }}>
</span>
