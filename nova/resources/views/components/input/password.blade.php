@props([
    'leadingAddOn' => false,
])

<x-input.field
    x-data="{ type: 'password', showPassword: false }"
    x-init="$watch('showPassword', value => type = (value) ? 'text' : 'password')"
    :leading-add-on="$leadingAddOn"
>
    <input :type="type" class="flex-1 appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100" {{ $attributes }}>

    <x-slot:trailingAddOn>
        <button @click="showPassword = !showPassword" type="button" class="focus:outline-none" x-cloak>
            <div x-show="showPassword" class="leading-0">
                @icon('hide')
            </div>
            <div x-show="!showPassword" class="leading-0">
                @icon('show')
            </div>
        </button>
    </x-slot:trailingAddOn>
</x-input.field>