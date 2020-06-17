@props([
    'leadingAddOn' => false,
])

<div
    x-data="{ type: 'password', showPassword: false }"
    x-init="$watch('showPassword', value => type = (value) ? 'text' : 'password')"
    class="field-group"
>
    @if ($leadingAddOn)
        <div class="field-addon">
            {{ $leadingAddOn }}
        </div>
    @endif

    <input x-bind:type="type" class="field" {{ $attributes }}>

    <button x-on:click="showPassword = !showPassword" type="button" class="field-addon">
        <div x-show="showPassword" class="leading-0">
            @icon('hide')
        </div>
        <div x-show="!showPassword" class="leading-0">
            @icon('show')
        </div>
    </button>
</div>
