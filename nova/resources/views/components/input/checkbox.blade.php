@props(['label', 'for'])

<label for="{{ $for }}" class="inline-flex items-center">
    <input type="checkbox" {{ $attributes->merge(['class' => 'form-checkbox']) }}>
    <span class="ml-2">{{ $label }}</span>
</label>