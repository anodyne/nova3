@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@php
    $parentClasses = 'group flex w-full shrink-0 items-center rounded-md px-4 py-2 text-base font-medium text-gray-700 transition hover:bg-gray-100 focus:outline-none md:text-sm dark:text-gray-300 dark:hover:bg-gray-600/50';

    $iconClasses = 'mr-3 shrink-0 text-gray-500 dark:text-gray-400';
@endphp

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => $parentClasses]) }} role="menuitem">
        @if ($icon)
            <x-icon :name="$icon" size="sm" :class="$iconClasses"></x-icon>
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => $type, 'class' => $parentClasses]) }} role="menuitem">
        @if ($icon)
            <x-icon :name="$icon" size="sm" :class="$iconClasses"></x-icon>
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@else
    <div {{ $attributes->merge(['class' => $parentClasses]) }} role="menuitem">
        @if ($icon)
            <x-icon :name="$icon" size="sm" :class="$iconClasses"></x-icon>
        @endif

        {{ $slot }}
    </div>
@endif
