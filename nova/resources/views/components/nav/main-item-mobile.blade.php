@props([
    'active' => false,
])

<a class="{{ $active ? 'text-blue-600 dark:text-blue-400 bg-blue-100/75 dark:bg-blue-900/40' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100' }} block rounded-md py-2 px-3 text-base font-medium transition" {{ $attributes }}>
    {{ $slot }}
</a>