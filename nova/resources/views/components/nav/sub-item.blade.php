@props([
    'active' => false,
])

<a class="{{ $active ? 'text-blue-500 border-blue-400 dark:border-blue-500 font-semibold' : 'hover:text-gray-900 dark:hover:text-gray-100 hover:border-gray-400 dark:hover:border-gray-600 border-transparent' }} group -ml-0.5 px-3 py-1 flex border-l-2 items-center text-base md:text-sm transition" {{ $attributes }}>
    <span class="truncate">
        {{ $slot }}
    </span>
</a>