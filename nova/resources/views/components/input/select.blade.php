@aware(['error'])

<select
    @class([
        'form-select block w-full pl-3 pr-10 py-2.5 border-0 ring-1 ring-inset text-base bg-white dark:bg-opacity-5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-inset rounded-md shadow-sm',
        'ring-gray-300 focus-within:ring-primary-600 dark:ring-white/10 dark:focus-within:ring-primary-500' => !$error,
        'ring-danger-600 dark:ring-danger-500 focus-within:ring-danger-600 dark:focus-within:ring-danger-500' => $error,
        $attributes->get('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</select>
