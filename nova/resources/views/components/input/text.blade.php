@props([
    'leading' => false,
    'trailing' => false,
])

@aware(['error'])

<x-input.field :leading="$leading" :trailing="$trailing">
    <input type="text" class="form-field" {{ $attributes }} />
</x-input.field>
