@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => 'group rounded flex items-center w-full px-4 py-2 text-sm font-medium text-gray-11 transition ease-in-out duration-150 hover:bg-gray-3 hover:text-gray-12 focus:outline-none focus:bg-gray-3 focus:text-gray-12']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-5 w-5 text-gray-9 group-hover:text-gray-10 group-focus:text-gray-10')
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => $type, 'class' => 'group rounded flex items-center w-full px-4 py-2 text-sm font-medium text-gray-11 transition ease-in-out duration-150 hover:bg-gray-3 hover:text-gray-12 focus:outline-none focus:bg-gray-3 focus:text-gray-12']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-5 w-5 text-gray-9 group-hover:text-gray-10 group-focus:text-gray-10')
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@endif