@props([
    'label' => false,
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center space-x-2">
    <input type="checkbox" {{ $attributes->merge(['class' => 'rounded border-gray-6 text-blue-9 bg-gray-1 focus:ring-offset-gray-1 focus:ring-blue-7']) }} @if ($checked) checked @endif>

    @if ($label)
        <span>{{ $label }}</span>
    @endif
</label>
