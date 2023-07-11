@aware(['error'])

<select
    @class([
        'form-select block w-full rounded-md border-0 bg-white py-2.5 pl-3 pr-10 text-base text-gray-900 shadow-sm ring-1 ring-inset focus:outline-none focus:ring-2 focus:ring-inset dark:bg-opacity-5 dark:text-white',
        'ring-gray-300 focus-within:ring-primary-600 dark:ring-white/10 dark:focus-within:ring-primary-500' => ! $error,
        'ring-danger-600 focus-within:ring-danger-600 dark:ring-danger-500 dark:focus-within:ring-danger-500' => $error,
        $attributes->get('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</select>
