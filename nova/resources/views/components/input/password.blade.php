<div
    data-slot="control"
    x-data="{ type: 'password', showPassword: false }"
    x-init="$watch('showPassword', (value) => (type = value ? 'text' : 'password'))"
    class="flex items-center gap-x-2"
>
    <x-input x-bind:type="type" {{ $attributes }} />

    <x-button x-on:click="showPassword = !showPassword" type="button" color="neutral" tabindex="-1" x-cloak text>
        <div x-show="showPassword" class="leading-0">
            <x-icon name="hide" size="sm"></x-icon>
        </div>
        <div x-show="!showPassword" class="leading-0">
            <x-icon name="show" size="sm"></x-icon>
        </div>
    </x-button>
</div>
