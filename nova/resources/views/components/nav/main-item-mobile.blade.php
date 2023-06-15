@props([
    'active' => false,
    'icon' => false,
    'meta',
])

<a @class([
    'group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold',
    'text-gray-400 hover:bg-gray-800 hover:text-white' => ! $active,
    'bg-gray-800 text-white' => $active,
]) {{ $attributes }}>
    @if ($icon)
        <x-icon :name="$icon" size="sm"></x-icon>
    @endif

    <span class="w-full">{{ $slot }}</span>
</a>

@if ($active && $meta->subnav)
    <aside class="pl-4">
        @include($meta->subnav)
    </aside>
@endif
