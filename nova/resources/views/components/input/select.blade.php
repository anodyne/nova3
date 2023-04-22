@aware(['error'])

<select
    @class([
        'ring-gray-300 dark:ring-gray-200/[15%] focus:ring-primary-400 focus:ring-primary-400 dark:focus:ring-primary-600 dark:focus:ring-primary-600' => !$error,
        'ring-danger-300 dark:ring-danger-600 focus:ring-danger-400 dark:focus:ring-danger-600 focus:ring-danger-400 dark:focus:ring-danger-600' => $error,
        'form-select block w-full pl-3 pr-10 py-2.5 border-0 ring-1 ring-inset text-base bg-white dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 dark:focus:bg-gray-800 focus:outline-none focus:ring-2 rounded-md shadow-sm',
        $attributes->get('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</select>
