@props([
    'label',
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center space-x-2">
    <input type="radio" {{ $attributes->merge(['class' => 'form-radio']) }} @if ($checked) checked @endif>
    <span>{{ $label }}</span>
</label>
