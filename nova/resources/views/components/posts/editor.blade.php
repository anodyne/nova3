@props([
    'field',
    'name',
    'suggestion',
    'value'
])

@if ($field->enabled)
    <div class="flex flex-col space-y-1 w-full">
        <div class="group flex items-center w-full space-x-2">
            <x-editor.minimal placeholder="Write something awesome..." {{ $attributes->whereStartsWith('wire:model') }}></x-editor.minimal>
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