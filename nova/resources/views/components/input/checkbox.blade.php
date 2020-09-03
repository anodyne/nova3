@props([
    'label',
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center space-x-2">
    <input type="checkbox" {{ $attributes->merge(['class' => 'form-checkbox']) }} @if ($checked) checked @endif>
    <span>{{ $label }}</span>
</label>
