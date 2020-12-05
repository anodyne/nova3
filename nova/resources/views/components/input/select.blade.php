<select {{ $attributes->merge(['class' => 'block w-full pl-3 pr-10 py-2 text-base border-gray-200 focus:outline-none focus:ring-blue-400 focus:border-blue-400 rounded-md shadow-sm']) }}>
    {{ $slot }}
</select>
