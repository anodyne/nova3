@props([
    'field',
    'icon' => false,
    'name',
    'suggestion',
    'value',
])

@if ($field->enabled)
    <div class="flex w-full flex-col space-y-1">
        <x-input.field>
            <x-slot name="leading">
                @if ($icon)
                    <x-icon :name="$icon" size="sm" class="text-gray-500 group-focus-within:text-gray-600"></x-icon>
                @endif
            </x-slot>

            <input type="text" {{ $attributes->merge(['class' => 'form-field']) }} />
        </x-input.field>

        @if ($field->suggest && $suggestion && ! $value)
            <div class="text-xs">
                <span class="font-medium text-gray-600">Suggested:</span>
                <x-button wire:click="$set('{{ $name }}', '{{ $suggestion->{$name} }}')" color="primary" text>
                    {{ $suggestion->{$name} }}
                </x-button>
            </div>
        @endif
    </div>
@endif
