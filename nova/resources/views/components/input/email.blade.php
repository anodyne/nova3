@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

<x-input.field :leading-add-on="$leadingAddOn" :trailing-add-on="$trailingAddOn">
    <input type="email" class="flex-1 appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100" {{ $attributes }}>
</x-input.field>
