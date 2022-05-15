<select {{ $attributes->merge(['class' => 'block w-full pl-3 pr-10 py-2 text-base bg-gray-50 dark:bg-gray-700/50 border-gray-200 dark:border-gray-200/[15%] focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 dark:focus:border-blue-400 rounded-md shadow-sm']) }}>
    {{ $slot }}
</select>
