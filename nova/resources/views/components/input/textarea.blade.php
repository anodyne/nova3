<x-input.field>
    <textarea class="flex-1 appearance-none bg-transparent text-gray-900 dark:text-gray-100 placeholder-gray-500 border-none p-0 focus:ring-0 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100" {{ $attributes->merge(['rows' => 5]) }}>{{ $slot }}</textarea>
</x-input.field>
