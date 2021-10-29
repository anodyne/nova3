@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-sm font-medium text-gray-11 transition ease-in-out duration-200 hover:bg-red-4 hover:text-red-11 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-5 w-5 text-gray-9 group-hover:text-red-9')
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => 'button', 'class' => 'group rounded-md flex items-center w-full px-4 py-2 text-sm font-medium text-gray-11 transition ease-in-out duration-200 hover:bg-red-4 hover:text-red-11 focus:outline-none']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-5 w-5 text-gray-9 group-hover:text-red-9')
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@endif