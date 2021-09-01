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
            <x-slot name="leadingAddOn">
                @if ($icon)
                    @icon($icon, 'h-5 w-5 text-gray-9 group-focus-within:text-gray-11')
                @endif
            </x-slot>

            <input type="text" {{ $attributes->merge(['class' => 'form-field']) }}>
        </x-input.field>

        @if ($field->suggest && $suggestion && ! $value)
            <div class="text-xs">
                <span class="font-medium text-gray-11">Suggested:</span>
                <x-button
                    wire:click="$set('{{ $name }}', '{{ $suggestion->{$name} }}')"
                    color="blue-text"
                    size="none-xs"
                >{{ $suggestion->{$name} }}</x-button>
            </div>
        @endif
    </div>
@endif