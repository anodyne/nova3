@props([
    'field',
    'icon' => false,
    'name',
    'suggestion',
    'value'
])

@if ($field->enabled)
    <div class="flex flex-col space-y-1 w-full">
        <div class="group flex items-center w-full space-x-2">
            @if($icon)
                @icon($icon, 'h-5 w-5 text-gray-400 group-focus-within:text-gray-600')
            @endif

            <input
                type="text"
                {{ $attributes->merge(['class' => 'w-full bg-transparent appearance-none focus:outline-none text-base font-medium text-gray-700 placeholder-gray-400']) }}
            >
        </div>

        @if ($field->suggest && $suggestion && ! $value)
            <div class="text-xs">
                <span class="font-medium text-gray-600">Suggested:</span>
                <x-button
                    wire:click="$set('{{ $name }}', '{{ $suggestion->{$name} }}')"
                    color="blue-text"
                    size="none-xs"
                >{{ $suggestion->{$name} }}</x-button>
            </div>
        @endif
    </div>
@endif