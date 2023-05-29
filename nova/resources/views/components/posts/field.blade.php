@props([
    'field',
    'icon' => false,
    'name',
    'suggestion',
    'value'
])

@if ($field->enabled)
    <div class="flex flex-col space-y-1 w-full">
        <x-input.field>
            <x-slot:leadingAddOn>
                @if ($icon)
                    <x-icon :name="$icon" size="sm" class="text-gray-500 group-focus-within:text-gray-600"></x-icon>
                @endif
            </x-slot:leadingAddOn>

            <input type="text" {{ $attributes->merge(['class' => 'form-field']) }}>
        </x-input.field>

        @if ($field->suggest && $suggestion && ! $value)
            <div class="text-xs">
                <span class="font-medium text-gray-600">Suggested:</span>
                <x-button.text
                    wire:click="$set('{{ $name }}', '{{ $suggestion->{$name} }}')"
                    color="primary"
                >{{ $suggestion->{$name} }}</x-button.text>
            </div>
        @endif
    </div>
@endif