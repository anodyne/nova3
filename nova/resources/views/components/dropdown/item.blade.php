@props([
    'type' => 'link',
    'icon' => false,
    'buttonForm' => false,
])

@if ($type === 'link')
    <a {{ $attributes->merge(['href' => '#', 'class' => 'group flex items-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition ease-in-out duration-150 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500')
        @endif

        {{ $slot }}
    </a>
@elseif ($type === 'button' || $type === 'submit')
    <button {{ $attributes->merge(['type' => 'button', 'class' => 'group flex items-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition ease-in-out duration-150 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900']) }} role="menuitem">
        @if ($icon)
            @icon($icon, 'mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500')
        @endif

        {{ $slot }}
    </button>

    @if ($buttonForm)
        {{ $buttonForm }}
    @endif
@endif