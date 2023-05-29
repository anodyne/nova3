@props([
    'leadingAddOn' => false,
])

<x-input.field
    x-data="{ type: 'password', showPassword: false }"
    x-init="$watch('showPassword', value => type = (value) ? 'text' : 'password')"
    :leading-add-on="$leadingAddOn"
>
    <input :type="type" class="flex-1 appearance-none bg-transparent text-gray-900 dark:text-white placeholder-gray-500 border-none p-0 focus:ring-0 focus:outline-none focus:text-gray-900 dark:focus:text-white" {{ $attributes }}>

    <x-slot:trailingAddOn>
        <button @click="showPassword = !showPassword" type="button" class="focus:outline-none" x-cloak>
            <div x-show="showPassword" class="leading-0">
                <x-icon name="hide" size="sm"></x-icon>
            </div>
            <div x-show="!showPassword" class="leading-0">
                <x-icon name="show" size="sm"></x-icon>
            </div>
        </button>
    </x-slot:trailingAddOn>
</x-input.field>
