@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium text-gray-11 transition ease-in-out duration-200 hover:bg-gray-4 hover:text-gray-12 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-6 w-6 md:h-5 md:w-5 text-gray-9 group-hover:text-gray-10')
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => $type, 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium text-gray-11 transition ease-in-out duration-200 hover:bg-gray-4 hover:text-gray-12 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-6 w-6 md:h-5 md:w-5 text-gray-9 group-hover:text-gray-10')
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@endif