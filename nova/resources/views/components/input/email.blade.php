@props([
    'leading' => false,
    'trailing' => false,
])

<x-input.field :leading="$leading" :trailing="$trailing">
    <input type="email" class="form-field" {{ $attributes }} />
</x-input.field>
