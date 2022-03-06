@props([
    'label' => false,
    'for' => false,
    'checked' => false,
])

<label for="{{ $for }}" class="inline-flex items-center space-x-2">
    <input type="radio" {{ $attributes->merge(['class' => 'rounded-full border-gray-6 text-blue-9 bg-gray-1 focus:ring-offset-gray-1 focus:ring-blue-7']) }} @checked($checked)>

    @if ($label)
        <span class="text-gray-11">{{ $label }}</span>
    @endif
</label>
