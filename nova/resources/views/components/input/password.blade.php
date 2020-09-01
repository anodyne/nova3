@props([
    'leadingAddOn' => false,
])

<x-input.field
    x-data="{ type: 'password', showPassword: false }"
    x-init="$watch('showPassword', value => type = (value) ? 'text' : 'password')"
    :leading-add-on="$leadingAddOn"
>
    <input x-bind:type="type" class="form-field" {{ $attributes }}>

    <x-slot name="trailingAddOn">
        <button x-on:click="showPassword = !showPassword" type="button" class="focus:outline-none" x-cloak>
            <div x-show="showPassword" class="leading-0">
                @icon('hide')
            </div>
            <div x-show="!showPassword" class="leading-0">
                @icon('show')
            </div>
        </button>
    </x-slot>
</x-input.field>