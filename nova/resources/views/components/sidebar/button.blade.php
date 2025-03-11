@props([
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
                'relative flex w-full items-center gap-3 rounded-lg px-2 py-2.5 text-left text-base/6 font-medium sm:py-2 sm:text-sm/5',
                'bg-primary-100 text-primary-600 ring-1 ring-primary-200',

                // Leading icon/icon-only
                'data-[slot=icon]:*:size-6 data-[slot=icon]:*:shrink-0 data-[slot=icon]:*:text-primary-500 sm:data-[slot=icon]:*:size-5',

                // Trailing icon (down chevron or similar)
                'data-[slot=icon]:last:*:ml-auto data-[slot=icon]:last:*:size-5 sm:data-[slot=icon]:last:*:size-4',

                // Avatar
                'data-[slot=avatar]:*:-m-0.5 data-[slot=avatar]:*:size-7 data-[slot=avatar]:*:[--ring-opacity:10%] sm:data-[slot=avatar]:*:size-6',

                // Hover
                // 'hover:bg-gray-950/5 data-[slot=icon]:*:hover:text-gray-950',

                // Active
                'active:bg-gray-950/5 data-[slot=icon]:*:active:text-gray-950',

                // Focus
                'focus:outline-none',

                // Dark mode
                'dark:text-white dark:data-[slot=icon]:*:text-gray-400',
                'dark:hover:bg-white/5 dark:data-[slot=icon]:*:hover:text-white',
                'dark:active:bg-white/5 dark:data-[slot=icon]:*:active:text-white',
                'dark:data-[slot=icon]:*:data-[current]:text-white',
            ])
        }}
        {{ $attributes->has('href') ? 'wire:navigate' : null }}
    >
        {{ $slot }}

        @if (filled($trailing))
            <div class="absolute right-2 shrink-0">
                {{ $trailing }}
            </div>
        @endif
    </{{ $tag }}>
</span>
