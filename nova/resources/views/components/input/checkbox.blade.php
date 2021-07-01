@props([
    'label',
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center space-x-2">
    <input type="checkbox" {{ $attributes->merge(['class' => 'rounded border-gray-6 text-blue-9']) }} @if ($checked) checked @endif>
    <span>{{ $label }}</span>
</label>
