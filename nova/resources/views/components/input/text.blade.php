@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

<x-input.field :leading-add-on="$leadingAddOn" :trailing-add-on="$trailingAddOn">
    <input type="text" class="form-field" {{ $attributes }}>
</x-input.field>
