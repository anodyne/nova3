@props([
    'current' => false,
    'meta' => null,
    'trailing' => null,
    'icon' => null,
])

<flux:sidebar.item
    {{
        $attributes
            ->merge(['current' => $current, 'badge:class' => 'tabular-nums'])
            ->class([
                'data-current:border-none data-current:text-gray-900 data-current:shadow-xs data-current:ring-1 data-current:ring-gray-200 data-current:ring-inset',
                'dark:data-current:shadow dark:data-current:ring-white/10',
            ])
    }}
    wire:navigate
    :accent="false"
>
    @if ($icon)
        <x-slot name="icon">
            <x-icon :name="$icon" size="sm" />
        </x-slot>
    @endif

    {{ $slot }}
</flux:sidebar.item>

@if ($current && $meta?->subnav)
    <aside class="pl-5 in-data-flux-sidebar-collapsed-desktop:hidden">
        @include($meta?->subnav)
    </aside>
@endif
