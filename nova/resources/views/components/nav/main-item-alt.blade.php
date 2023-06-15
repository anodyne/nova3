@props([
    'active' => false,
])

<a @class([
    'inline-flex items-center rounded-md px-3 py-2 text-sm font-medium transition',
    'bg-primary-100/75 text-primary-600 dark:bg-primary-900/40 dark:text-primary-400' => $active,
    'hover:bg-gray-100 hover:text-gray-900 dark:hover:bg-gray-700/50 dark:hover:text-gray-100' => ! $active,
]) {{ $attributes }}>
    {{ $slot }}
</a>
