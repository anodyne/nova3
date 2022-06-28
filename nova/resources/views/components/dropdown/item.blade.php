@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600/50 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-6 w-6 md:h-5 md:w-5 text-gray-500 dark:text-gray-400')
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => $type, 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600/50 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-6 w-6 md:h-5 md:w-5 text-gray-500 dark:text-gray-400')
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@endif
