@props([
    'active' => false,
])

<a class="{{ $active ? 'text-blue-11 hover:text-blue-11 border-blue-9 font-semibold' : 'text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent' }} group -ml-0.5 px-3 py-1 flex border-l-2 items-center text-base md:text-sm transition ease-in-out duration-200" {{ $attributes }}>
    <span class="truncate">
        {{ $slot }}
    </span>
</a>