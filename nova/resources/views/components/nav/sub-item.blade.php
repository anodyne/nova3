@props([
    'active' => false,
])

<a class="{{ $active ? 'text-blue-11 hover:text-blue-11 border-blue-9 font-semibold' : 'text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium' }} group px-3 py-1 flex items-center text-base md:text-sm border-l-2 transition ease-in-out duration-200" {{ $attributes }}>
    <span class="truncate">
        {{ $slot }}
    </span>
</a>