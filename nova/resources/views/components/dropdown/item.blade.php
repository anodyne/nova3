@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
    'variant' => null,
])

@php
    $parentClasses = [
        'group flex w-full shrink-0 items-center rounded-[calc(var(--radius-xl))-(--spacing(1))] px-2 py-2 text-sm font-medium text-white',
        'focus:bg-white/10 focus:outline-hidden', // Tailwind Elements uses focus rather than hover for some reason
        match ($variant) {
            'danger' => 'focus:text-danger-500',
            default => 'focus:text-white',
        },
    ];

    $iconClasses = Arr::toCssClasses([
        'mr-3 shrink-0 text-gray-400',
        match ($variant) {
            'danger' => 'group-focus:text-danger-500',
            default => 'group-focus:text-gray-300',
        },
    ]);
@endphp

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#'])->class($parentClasses) }}>
        @if ($icon)
            <x-icon :name="$icon" size="sm" :class="$iconClasses"></x-icon>
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => $type])->class($parentClasses) }}>
        @if ($icon)
            <x-icon :name="$icon" size="sm" :class="$iconClasses"></x-icon>
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@else
    <div {{ $attributes->class($parentClasses) }}>
        @if ($icon)
            <x-icon :name="$icon" size="sm" :class="$iconClasses"></x-icon>
        @endif

        {{ $slot }}
    </div>
@endif
