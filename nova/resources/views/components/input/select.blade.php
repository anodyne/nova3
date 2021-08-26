<select {{ $attributes->merge(['class' => 'block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring-blue-7 focus:border-blue-7 rounded-md shadow-sm']) }}>
    {{ $slot }}
</select>
