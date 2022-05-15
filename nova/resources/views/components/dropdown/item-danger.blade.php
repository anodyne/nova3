@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-500 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900 hover:text-red-600 dark:hover:text-red-100 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-6 w-6 md:h-5 md:w-5 text-gray-400 group-hover:text-red-500 dark:group-hover:text-red-300')
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => 'button', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-500 dark:text-gray-400 hover:bg-red-50 dark:hover:bg-red-900 hover:text-red-600 dark:hover:text-red-100 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-6 w-6 md:h-5 md:w-5 text-gray-400 group-hover:text-red-500 dark:group-hover:text-red-300')
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@endif