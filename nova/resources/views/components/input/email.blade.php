@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

<x-input.field :leading-add-on="$leadingAddOn">
    <input type="email" class="form-field" {{ $attributes }}>
</x-input.field>
