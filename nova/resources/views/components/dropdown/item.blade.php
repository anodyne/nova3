@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600/50 focus:outline-none shrink-0']) }} role="menuitem">
        @if ($icon)
            <x-icon :name="$icon" size="sm" class="mr-3 text-gray-500 dark:text-gray-400"></x-icon>
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => $type, 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600/50 focus:outline-none shrink-0']) }} role="menuitem">
        @if ($icon)
            <x-icon :name="$icon" size="sm" class="mr-3 text-gray-500 dark:text-gray-400"></x-icon>
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@endif
