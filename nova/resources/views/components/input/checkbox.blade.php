@props([
    'label',
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center">
    <input type="checkbox" {{ $attributes->merge(['class' => 'form-checkbox']) }} @if ($checked) checked @endif>
    <span class="ml-2">{{ $label }}</span>
</label>
