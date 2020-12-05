@props([
    'label',
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center space-x-2">
    <input type="radio" {{ $attributes->merge(['class' => 'rounded-full border-gray-200 text-blue-500']) }} @if ($checked) checked @endif>
    <span>{{ $label }}</span>
</label>
