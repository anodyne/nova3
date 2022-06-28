@aware(['error'])

<select
    @class([
        'border-gray-300 dark:border-gray-200/[15%] focus:border-primary-400 focus:ring-primary-400 dark:focus:border-primary-600 dark:focus:ring-primary-600' => !$error,
        'border-error-300 dark:border-error-600 focus:border-error-400 dark:focus:border-error-600 focus:ring-error-400 dark:focus:ring-error-600' => $error,
        'form-select block w-full pl-3 pr-10 py-2 text-base bg-white dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 dark:focus:bg-gray-800 focus:outline-none focus:ring-1 rounded-md shadow-sm',
    ])
    {{ $attributes }}
>
    {{ $slot }}
</select>
