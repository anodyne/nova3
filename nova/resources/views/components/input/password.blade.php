@props([
    'leading' => false,
])

<x-input.field
    x-data="{ type: 'password', showPassword: false }"
    x-init="$watch('showPassword', value => type = (value) ? 'text' : 'password')"
    :leading="$leading"
>
    <input
        :type="type"
        class="flex-1 appearance-none border-none bg-transparent p-0 text-gray-900 placeholder-gray-500 focus:text-gray-900 focus:outline-none focus:ring-0 dark:text-white dark:focus:text-white"
        {{ $attributes }}
    />

    <x-slot name="trailing">
        <button
            x-on:click="showPassword = !showPassword"
            type="button"
            class="focus:outline-none"
            tabindex="-1"
            x-cloak
        >
            <div x-show="showPassword" class="leading-0">
                <x-icon name="hide" size="sm"></x-icon>
            </div>
            <div x-show="!showPassword" class="leading-0">
                <x-icon name="show" size="sm"></x-icon>
            </div>
        </button>
    </x-slot>
</x-input.field>
