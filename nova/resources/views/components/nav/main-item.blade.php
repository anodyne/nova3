@props([
    'active' => false,
])

<a class="{{ $active ? 'text-blue-11 bg-blue-3' : 'text-gray-12 hover:bg-gray-3 hover:text-gray-12' }} rounded-md py-2 px-3 inline-flex items-center text-sm font-medium transition duration-150" {{ $attributes }}>
    {{ $slot }}
</a>