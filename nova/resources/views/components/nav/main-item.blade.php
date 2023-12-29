@props([
    'active' => false,
    'icon' => false,
    'meta',
])

<a
    @class([
        'relative inline-flex w-full items-center px-6 text-sm font-medium transition',
        'text-gray-900 dark:text-white' => $active,
        'hover:text-gray-700 dark:hover:text-gray-300' => ! $active,
    ])
    {{ $attributes }}
>
    @if ($active)
        <div
            @class([
                'absolute left-0 h-full w-[3px] rounded-full rounded-l',
                'bg-gray-900 dark:bg-white' => settings('appearance.panda'),
                'bg-primary-500' => ! settings('appearance.panda'),
            ])
        ></div>
    @endif

    @if ($icon)
        <x-icon :name="$icon" size="md" class="mr-2.5"></x-icon>
    @endif

    <span class="w-full">{{ $slot }}</span>
</a>

@if ($active && $meta->subnav)
    <aside class="pl-[2.125rem]">
        @include($meta->subnav)
    </aside>
@endif
