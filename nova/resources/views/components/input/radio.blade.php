@props([
    'label',
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center">
    <input type="radio" {{ $attributes->merge(['class' => 'form-radio']) }} @if ($checked) checked @endif>
    <span class="ml-2">{{ $label }}</span>
</label>
