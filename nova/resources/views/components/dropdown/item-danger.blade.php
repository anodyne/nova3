@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-700 dark:text-gray-400 hover:bg-error-50 dark:hover:bg-error-900 hover:text-error-700 dark:hover:text-error-200 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-6 w-6 md:h-5 md:w-5 text-gray-500 dark:text-gray-400 group-hover:text-error-500 dark:group-hover:text-error-300')
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => 'button', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-700 dark:text-gray-400 hover:bg-error-50 dark:hover:bg-error-900 hover:text-error-700 dark:hover:text-error-200 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-6 w-6 md:h-5 md:w-5 text-gray-500 dark:text-gray-400 group-hover:text-error-500 dark:group-hover:text-error-300')
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@endif
