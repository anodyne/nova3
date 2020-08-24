<x-input.field>
    <textarea class="form-field" {{ $attributes->merge(['rows' => 5]) }}>{{ $slot }}</textarea>
</x-input.field>
